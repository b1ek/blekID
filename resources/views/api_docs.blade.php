<x-templates.master no-locale-style='true'>
<x-slot:head>
<x-embed-style src='/static/css/docs.css'></x-embed-style>
</x-slot:head>

<style>
.center-login-form {
    width: 80vw;
    height: 64vh;
    padding: 64px 32px;
}
.scroller {
    width: 100%;
    height: 100%;
    overflow-y: auto;
    border: 1px solid #fefffe;
}
</style>

<div class='scroller'>
    <h1>blek! ID (BID) API Documentation</h1>


    <h2>Basics</h2>
    <p>
        To redirect a user to auth page, simply redirect them to link
        <span class='code'>https://id.blek.codes/auth/APP_ID</span>.<br/>
        After user completes the authentication, they will be redirected to <span class='code'>https://your.app/customly/set/path?from=login&session=auth_session_id</span>. <span class='code'>auth_session_id</span> is a unique user session, which will be used by your app to get the account information.<br/>
    </p>



    <h2>Getting user data</h2>
    <p>
        After you obtain <span class='code'>auth_session_id</span>, you will be able to get the user data at <span class='code'>https://id.blek.codes/api/userdata?id=session_id&appid=app_id&secret=secret</span><br/>
        Parameters<br/>
        <table width=400>
            <tr>
                <td align='center'><span class='code'>id</span></td>
                <td>Session id, that you got from the user</td>
            </tr>
            <tr>
                <td align='center'><span class='code'>secret</span></td>
                <td>Your app's secret code. Keep it that way.</td>
            </tr>
            <tr>
                <td align='center'><span class='code'>appid</span></td>
                <td>App id</td>
            </tr>
        </table>
    </p>
    <p>Sample return data</p>
    <pre>
{
    "id": 1,
    "login": "blek!",
    "email": "me@blek.codes",
    "passhash": "b_1b57b48d4d08b569b********c86011d0a7593a15d6a2765fafe",
    "created": 1665674183, // when the account was created
    "data": [
        {
        "uid": 1,
        "appid": 1,
        "key": "gender",
        "value": "true"
        }
    ]
}
    </pre>



    <h2>"Silent" login</h2>
    <p>
    <span style='color:darkred;font-size:12pt;font-weight:bold'>This was disabled due to security issues.</span><br/>
    If you don't want your users to see the BID form, use the API to get access token:<br/>
    <span class='code'>https://id.blek.codes/api/login?login=USER_LOGIN&pass=USER_PASS&secret=APP_SECRET&appid=APP_ID</span><br/>
    Parameters
    </p>
    <table width=400>
        <tr>
            <td align='center'><span class='code'>login</span></td>
            <td>User login, supplied by your application</td>
        </tr>
        <tr>
            <td align='center'><span class='code'>pass</span></td>
            <td>SHA512 hashed user password, supplied by your application</td>
        </tr>
        <tr>
            <td align='center'><span class='code'>secret</span></td>
            <td>Your application's secret</td>
        </tr>
        <tr>
            <td align='center'><span class='code'>appid</span></td>
            <td>Your application</td>
        </tr>
    </table>
    <p>
        Return value is a plain text containing just the session id<br/>
        In case of failure, an error code will be returned. Error code starts with <span class='code'>Z_</span><br/>
        List of error codes:<br/>
        <table>
            <tr>
                <td align='center'>Code</td>
                <td align='center'>Meaning</td>
            </tr>
            <tr>
                <td align='center'><span class='code'>1</span></td>
                <td>Invalid login or password</td>
            </tr>
            <tr>
                <td align='center'><span class='code'>2</span></td>
                <td>Internal error (DB error, for example)</td>
            </tr>
            <tr>
                <td align='center'><span class='code'>3</span></td>
                <td>The user disabled logging in to your application</td>
            </tr>
            <tr>
                <td align='center'><span class='code'>4</span></td>
                <td>The account is disabled</td>
            </tr>
        </table>
    </p>



    <h2>Silent registration</h2>
    <p>
        This API is not public information.
    </p>


    <h2>Password hashing</h2>
    <p>
        <span style='font-size:14pt'>Client side</span><br/>
        Its a simple SHA512 hash salted with <span class='code'>"blek_"</span>. Must be transported through TLS layer.<br/>
    </p>
    <br/>
    <span style='font-size:14pt'>Server side</span><br/>
    Its a php function:
    <pre>
    function bid_passhash($pass, $userid) {
        return 'b_' . hash('sha512', $pass.$userid) . hash('sha512', $userid . hash('crc32', $pass));
    }
    </pre>


    <h2>Retrieving public user data</h2>
    <p>
        Its got from <span class='code'>https://id.blek.codes/api/get_user_data?uid=USER_ID&secret=APP_SECRET</span><br/>
        Returned data is a JSON with all public data. Like this:
        <pre>
{
    "data": {
        "key": "value"
    }
}
        </pre>
    </p>

    <h2>Storing public user data</h2>
    <p>
        <span style='font-size:14pt;color:#aa6500'>IMPORTANT: </span>ALL data that you store in blek! ID is considered public information. <br/>
        You should ask the user if they are okay with this. Violating this rule will lead to ban of your app.<br/>
        <br/>
        To store user data, send a POST request (JSON) to <span class='code'>https://id.blek.codes/api/store&appid=APP_ID&secret=SECRET</span><br/>
        The URL parameters are not so interesting as your request body. An example:
    </p>
    <pre>
{
    "userid": 69,
    "data": {
        "key": "value",
        "favFood": "pizza"
    }
}
    </pre>
    <p>
        Limitations<br/>
         - Key value must be not longer than 32 characters, value shouldn't me more than 255 characters long.<br/>
         - One app can store 16 data keys for one user<br/>
    </p>
    <p>
        <span style='font-size:14pt;color:#aa6500'>IMPORTANT: </span><br/>
        ANY sensitive data, such as passwords is not allowed to be stored.<br/>
        If it will be stored, your app will be banned from the service.
    </p>

</div>

</x-templates.master>
