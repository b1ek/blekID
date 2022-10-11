/*
 * [js-sha512]{@link https://github.com/emn178/js-sha512}
 *
 * @version 0.8.0
 * @author Chen, Yi-Cyuan [emn178@gmail.com]
 * @copyright Chen, Yi-Cyuan 2014-2018
 * @license MIT
 */ !function(){"use strict";var F="input is invalid type",$="object"==typeof window,x=$?window:{};x.JS_SHA512_NO_WINDOW&&($=!1);var _=!$&&"object"==typeof self;!x.JS_SHA512_NO_NODE_JS&&"object"==typeof process&&process.versions&&process.versions.node?x=global:_&&(x=self);var h=!x.JS_SHA512_NO_COMMON_JS&&"object"==typeof module&&module.exports,t="function"==typeof define&&define.amd,i=!x.JS_SHA512_NO_ARRAY_BUFFER&&"undefined"!=typeof ArrayBuffer,s="0123456789abcdef".split(""),e=[-2147483648,8388608,32768,128],r=[24,16,8,0],n=[1116352408,3609767458,1899447441,602891725,3049323471,3964484399,3921009573,2173295548,961987163,4081628472,1508970993,3053834265,2453635748,2937671579,2870763221,3664609560,3624381080,2734883394,310598401,1164996542,607225278,1323610764,1426881987,3590304994,1925078388,4068182383,2162078206,991336113,2614888103,633803317,3248222580,3479774868,3835390401,2666613458,4022224774,944711139,264347078,2341262773,604807628,2007800933,770255983,1495990901,1249150122,1856431235,1555081692,3175218132,1996064986,2198950837,2554220882,3999719339,2821834349,766784016,2952996808,2566594879,3210313671,3203337956,3336571891,1034457026,3584528711,2466948901,113926993,3758326383,338241895,168717936,666307205,1188179964,773529912,1546045734,1294757372,1522805485,1396182291,2643833823,1695183700,2343527390,1986661051,1014477480,2177026350,1206759142,2456956037,344077627,2730485921,1290863460,2820302411,3158454273,3259730800,3505952657,3345764771,106217008,3516065817,3606008344,3600352804,1432725776,4094571909,1467031594,275423344,851169720,430227734,3100823752,506948616,1363258195,659060556,3750685593,883997877,3785050280,958139571,3318307427,1322822218,3812723403,1537002063,2003034995,1747873779,3602036899,1955562222,1575990012,2024104815,1125592928,2227730452,2716904306,2361852424,442776044,2428436474,593698344,2756734187,3733110249,3204031479,2999351573,3329325298,3815920427,3391569614,3928383900,3515267271,566280711,3940187606,3454069534,4118630271,4000239992,116418474,1914138554,174292421,2731055270,289380356,3203993006,460393269,320620315,685471733,587496836,852142971,1086792851,1017036298,365543100,1126000580,2618297676,1288033470,3409855158,1501505948,4234509866,1607167915,987167468,1816402316,1246189591],l=["hex","array","digest","arrayBuffer"],o=[];(x.JS_SHA512_NO_NODE_JS||!Array.isArray)&&(Array.isArray=function(F){return"[object Array]"===Object.prototype.toString.call(F)}),i&&(x.JS_SHA512_NO_ARRAY_BUFFER_IS_VIEW||!ArrayBuffer.isView)&&(ArrayBuffer.isView=function(F){return"object"==typeof F&&F.buffer&&F.buffer.constructor===ArrayBuffer});var B=function(F,$){return function(x){return new E($,!0).update(x)[F]()}},a=function(F){var $=B("hex",F);$.create=function(){return new E(F)},$.update=function(F){return $.create().update(F)};for(var x=0;x<l.length;++x){var _=l[x];$[_]=B(_,F)}return $},A=function(F,$){return function(x,_){return new f(x,$,!0).update(_)[F]()}},C=function(F){var $=A("hex",F);$.create=function($){return new f($,F)},$.update=function(F,x){return $.create(F).update(x)};for(var x=0;x<l.length;++x){var _=l[x];$[_]=A(_,F)}return $};function E(F,$){$?(o[0]=o[1]=o[2]=o[3]=o[4]=o[5]=o[6]=o[7]=o[8]=o[9]=o[10]=o[11]=o[12]=o[13]=o[14]=o[15]=o[16]=o[17]=o[18]=o[19]=o[20]=o[21]=o[22]=o[23]=o[24]=o[25]=o[26]=o[27]=o[28]=o[29]=o[30]=o[31]=o[32]=0,this.blocks=o):this.blocks=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],384==F?(this.h0h=3418070365,this.h0l=3238371032,this.h1h=1654270250,this.h1l=914150663,this.h2h=2438529370,this.h2l=812702999,this.h3h=355462360,this.h3l=4144912697,this.h4h=1731405415,this.h4l=4290775857,this.h5h=2394180231,this.h5l=1750603025,this.h6h=3675008525,this.h6l=1694076839,this.h7h=1203062813,this.h7l=3204075428):256==F?(this.h0h=573645204,this.h0l=4230739756,this.h1h=2673172387,this.h1l=3360449730,this.h2h=596883563,this.h2l=1867755857,this.h3h=2520282905,this.h3l=1497426621,this.h4h=2519219938,this.h4l=2827943907,this.h5h=3193839141,this.h5l=1401305490,this.h6h=721525244,this.h6l=746961066,this.h7h=246885852,this.h7l=2177182882):224==F?(this.h0h=2352822216,this.h0l=424955298,this.h1h=1944164710,this.h1l=2312950998,this.h2h=502970286,this.h2l=855612546,this.h3h=1738396948,this.h3l=1479516111,this.h4h=258812777,this.h4l=2077511080,this.h5h=2011393907,this.h5l=79989058,this.h6h=1067287976,this.h6l=1780299464,this.h7h=286451373,this.h7l=2446758561):(this.h0h=1779033703,this.h0l=4089235720,this.h1h=3144134277,this.h1l=2227873595,this.h2h=1013904242,this.h2l=4271175723,this.h3h=2773480762,this.h3l=1595750129,this.h4h=1359893119,this.h4l=2917565137,this.h5h=2600822924,this.h5l=725511199,this.h6h=528734635,this.h6l=4215389547,this.h7h=1541459225,this.h7l=327033209),this.bits=F,this.block=this.start=this.bytes=this.hBytes=0,this.finalized=this.hashed=!1}function f($,x,_){var h,t=typeof $;if("string"!==t){if("object"===t){if(null===$)throw Error(F);if(i&&$.constructor===ArrayBuffer)$=new Uint8Array($);else if(!Array.isArray($)&&(!i||!ArrayBuffer.isView($)))throw Error(F)}else throw Error(F);h=!0}var s=$.length;if(!h){for(var e,r=[],s=$.length,n=0,l=0;l<s;++l)(e=$.charCodeAt(l))<128?r[n++]=e:e<2048?(r[n++]=192|e>>6,r[n++]=128|63&e):e<55296||e>=57344?(r[n++]=224|e>>12,r[n++]=128|e>>6&63,r[n++]=128|63&e):(e=65536+((1023&e)<<10|1023&$.charCodeAt(++l)),r[n++]=240|e>>18,r[n++]=128|e>>12&63,r[n++]=128|e>>6&63,r[n++]=128|63&e);$=r}$.length>128&&($=new E(x,!0).update($).array());for(var o=[],B=[],l=0;l<128;++l){var a=$[l]||0;o[l]=92^a,B[l]=54^a}E.call(this,x,_),this.update(B),this.oKeyPad=o,this.inner=!0,this.sharedMemory=_}E.prototype.update=function($){if(this.finalized)throw Error("finalize already called");var x,_=typeof $;if("string"!==_){if("object"===_){if(null===$)throw Error(F);if(i&&$.constructor===ArrayBuffer)$=new Uint8Array($);else if(!Array.isArray($)&&(!i||!ArrayBuffer.isView($)))throw Error(F)}else throw Error(F);x=!0}for(var h,t,s=0,e=$.length,n=this.blocks;s<e;){if(this.hashed&&(this.hashed=!1,n[0]=this.block,n[1]=n[2]=n[3]=n[4]=n[5]=n[6]=n[7]=n[8]=n[9]=n[10]=n[11]=n[12]=n[13]=n[14]=n[15]=n[16]=n[17]=n[18]=n[19]=n[20]=n[21]=n[22]=n[23]=n[24]=n[25]=n[26]=n[27]=n[28]=n[29]=n[30]=n[31]=n[32]=0),x)for(t=this.start;s<e&&t<128;++s)n[t>>2]|=$[s]<<r[3&t++];else for(t=this.start;s<e&&t<128;++s)(h=$.charCodeAt(s))<128?n[t>>2]|=h<<r[3&t++]:h<2048?(n[t>>2]|=(192|h>>6)<<r[3&t++],n[t>>2]|=(128|63&h)<<r[3&t++]):h<55296||h>=57344?(n[t>>2]|=(224|h>>12)<<r[3&t++],n[t>>2]|=(128|h>>6&63)<<r[3&t++],n[t>>2]|=(128|63&h)<<r[3&t++]):(h=65536+((1023&h)<<10|1023&$.charCodeAt(++s)),n[t>>2]|=(240|h>>18)<<r[3&t++],n[t>>2]|=(128|h>>12&63)<<r[3&t++],n[t>>2]|=(128|h>>6&63)<<r[3&t++],n[t>>2]|=(128|63&h)<<r[3&t++]);this.lastByteIndex=t,this.bytes+=t-this.start,t>=128?(this.block=n[32],this.start=t-128,this.hash(),this.hashed=!0):this.start=t}return this.bytes>4294967295&&(this.hBytes+=this.bytes/4294967296<<0,this.bytes=this.bytes%4294967296),this},E.prototype.finalize=function(){if(!this.finalized){this.finalized=!0;var F=this.blocks,$=this.lastByteIndex;F[32]=this.block,F[$>>2]|=e[3&$],this.block=F[32],$>=112&&(this.hashed||this.hash(),F[0]=this.block,F[1]=F[2]=F[3]=F[4]=F[5]=F[6]=F[7]=F[8]=F[9]=F[10]=F[11]=F[12]=F[13]=F[14]=F[15]=F[16]=F[17]=F[18]=F[19]=F[20]=F[21]=F[22]=F[23]=F[24]=F[25]=F[26]=F[27]=F[28]=F[29]=F[30]=F[31]=F[32]=0),F[30]=this.hBytes<<3|this.bytes>>>29,F[31]=this.bytes<<3,this.hash()}},E.prototype.hash=function(){var F,$,x,_,h,t,i,s,e,r,l,o,B,a,A,C,E,f,D,c,u,p,y,d,b,v=this.h0h,w=this.h0l,S=this.h1h,U=this.h1l,g=this.h2h,k=this.h2l,z=this.h3h,O=this.h3l,N=this.h4h,J=this.h4l,j=this.h5h,m=this.h5l,H=this.h6h,I=this.h6l,R=this.h7h,K=this.h7l,P=this.blocks;for(F=32;F<160;F+=2)$=((c=P[F-30])>>>1|(u=P[F-29])<<31)^(c>>>8|u<<24)^c>>>7,x=(u>>>1|c<<31)^(u>>>8|c<<24)^(u>>>7|c<<25),_=((c=P[F-4])>>>19|(u=P[F-3])<<13)^(u>>>29|c<<3)^c>>>6,h=(u>>>19|c<<13)^(c>>>29|u<<3)^(u>>>6|c<<26),c=P[F-32],u=P[F-31],p=P[F-14],t=(65535&(y=P[F-13]))+(65535&u)+(65535&x)+(65535&h),s=(65535&p)+(65535&c)+(65535&$)+(65535&_)+((i=(y>>>16)+(u>>>16)+(x>>>16)+(h>>>16)+(t>>>16))>>>16),e=(p>>>16)+(c>>>16)+($>>>16)+(_>>>16)+(s>>>16),P[F]=e<<16|65535&s,P[F+1]=i<<16|65535&t;var V=v,M=w,T=S,W=U,Y=g,q=k,G=z,L=O,Q=N,X=J,Z=j,FF=m,F$=H,Fx=I,F_=R,Fh=K;for(F=0,C=T&Y,E=W&q;F<160;F+=8)$=(V>>>28|M<<4)^(M>>>2|V<<30)^(M>>>7|V<<25),x=(M>>>28|V<<4)^(V>>>2|M<<30)^(V>>>7|M<<25),_=(Q>>>14|X<<18)^(Q>>>18|X<<14)^(X>>>9|Q<<23),h=(X>>>14|Q<<18)^(X>>>18|Q<<14)^(Q>>>9|X<<23),r=V&T,l=M&W,f=r^V&Y^C,D=l^M&q^E,d=Q&Z^~Q&F$,b=X&FF^~X&Fx,c=P[F],u=P[F+1],p=n[F],t=(65535&(y=n[F+1]))+(65535&u)+(65535&b)+(65535&h)+(65535&Fh),s=(65535&p)+(65535&c)+(65535&d)+(65535&_)+(65535&F_)+((i=(y>>>16)+(u>>>16)+(b>>>16)+(h>>>16)+(Fh>>>16)+(t>>>16))>>>16),c=(e=(p>>>16)+(c>>>16)+(d>>>16)+(_>>>16)+(F_>>>16)+(s>>>16))<<16|65535&s,u=i<<16|65535&t,t=(65535&D)+(65535&x),s=(65535&f)+(65535&$)+((i=(D>>>16)+(x>>>16)+(t>>>16))>>>16),p=(e=(f>>>16)+($>>>16)+(s>>>16))<<16|65535&s,y=i<<16|65535&t,t=(65535&L)+(65535&u),s=(65535&G)+(65535&c)+((i=(L>>>16)+(u>>>16)+(t>>>16))>>>16),F_=(e=(G>>>16)+(c>>>16)+(s>>>16))<<16|65535&s,Fh=i<<16|65535&t,t=(65535&y)+(65535&u),s=(65535&p)+(65535&c)+((i=(y>>>16)+(u>>>16)+(t>>>16))>>>16),$=((G=(e=(p>>>16)+(c>>>16)+(s>>>16))<<16|65535&s)>>>28|(L=i<<16|65535&t)<<4)^(L>>>2|G<<30)^(L>>>7|G<<25),x=(L>>>28|G<<4)^(G>>>2|L<<30)^(G>>>7|L<<25),_=(F_>>>14|Fh<<18)^(F_>>>18|Fh<<14)^(Fh>>>9|F_<<23),h=(Fh>>>14|F_<<18)^(Fh>>>18|F_<<14)^(F_>>>9|Fh<<23),o=G&V,B=L&M,f=o^G&T^r,D=B^L&W^l,d=F_&Q^~F_&Z,b=Fh&X^~Fh&FF,c=P[F+2],u=P[F+3],p=n[F+2],t=(65535&(y=n[F+3]))+(65535&u)+(65535&b)+(65535&h)+(65535&Fx),s=(65535&p)+(65535&c)+(65535&d)+(65535&_)+(65535&F$)+((i=(y>>>16)+(u>>>16)+(b>>>16)+(h>>>16)+(Fx>>>16)+(t>>>16))>>>16),c=(e=(p>>>16)+(c>>>16)+(d>>>16)+(_>>>16)+(F$>>>16)+(s>>>16))<<16|65535&s,u=i<<16|65535&t,t=(65535&D)+(65535&x),s=(65535&f)+(65535&$)+((i=(D>>>16)+(x>>>16)+(t>>>16))>>>16),p=(e=(f>>>16)+($>>>16)+(s>>>16))<<16|65535&s,y=i<<16|65535&t,t=(65535&q)+(65535&u),s=(65535&Y)+(65535&c)+((i=(q>>>16)+(u>>>16)+(t>>>16))>>>16),F$=(e=(Y>>>16)+(c>>>16)+(s>>>16))<<16|65535&s,Fx=i<<16|65535&t,t=(65535&y)+(65535&u),s=(65535&p)+(65535&c)+((i=(y>>>16)+(u>>>16)+(t>>>16))>>>16),$=((Y=(e=(p>>>16)+(c>>>16)+(s>>>16))<<16|65535&s)>>>28|(q=i<<16|65535&t)<<4)^(q>>>2|Y<<30)^(q>>>7|Y<<25),x=(q>>>28|Y<<4)^(Y>>>2|q<<30)^(Y>>>7|q<<25),_=(F$>>>14|Fx<<18)^(F$>>>18|Fx<<14)^(Fx>>>9|F$<<23),h=(Fx>>>14|F$<<18)^(Fx>>>18|F$<<14)^(F$>>>9|Fx<<23),a=Y&G,A=q&L,f=a^Y&V^o,D=A^q&M^B,d=F$&F_^~F$&Q,b=Fx&Fh^~Fx&X,c=P[F+4],u=P[F+5],p=n[F+4],t=(65535&(y=n[F+5]))+(65535&u)+(65535&b)+(65535&h)+(65535&FF),s=(65535&p)+(65535&c)+(65535&d)+(65535&_)+(65535&Z)+((i=(y>>>16)+(u>>>16)+(b>>>16)+(h>>>16)+(FF>>>16)+(t>>>16))>>>16),c=(e=(p>>>16)+(c>>>16)+(d>>>16)+(_>>>16)+(Z>>>16)+(s>>>16))<<16|65535&s,u=i<<16|65535&t,t=(65535&D)+(65535&x),s=(65535&f)+(65535&$)+((i=(D>>>16)+(x>>>16)+(t>>>16))>>>16),p=(e=(f>>>16)+($>>>16)+(s>>>16))<<16|65535&s,y=i<<16|65535&t,t=(65535&W)+(65535&u),s=(65535&T)+(65535&c)+((i=(W>>>16)+(u>>>16)+(t>>>16))>>>16),Z=(e=(T>>>16)+(c>>>16)+(s>>>16))<<16|65535&s,FF=i<<16|65535&t,t=(65535&y)+(65535&u),s=(65535&p)+(65535&c)+((i=(y>>>16)+(u>>>16)+(t>>>16))>>>16),$=((T=(e=(p>>>16)+(c>>>16)+(s>>>16))<<16|65535&s)>>>28|(W=i<<16|65535&t)<<4)^(W>>>2|T<<30)^(W>>>7|T<<25),x=(W>>>28|T<<4)^(T>>>2|W<<30)^(T>>>7|W<<25),_=(Z>>>14|FF<<18)^(Z>>>18|FF<<14)^(FF>>>9|Z<<23),h=(FF>>>14|Z<<18)^(FF>>>18|Z<<14)^(Z>>>9|FF<<23),C=T&Y,E=W&q,f=C^T&G^a,D=E^W&L^A,d=Z&F$^~Z&F_,b=FF&Fx^~FF&Fh,c=P[F+6],u=P[F+7],p=n[F+6],t=(65535&(y=n[F+7]))+(65535&u)+(65535&b)+(65535&h)+(65535&X),s=(65535&p)+(65535&c)+(65535&d)+(65535&_)+(65535&Q)+((i=(y>>>16)+(u>>>16)+(b>>>16)+(h>>>16)+(X>>>16)+(t>>>16))>>>16),c=(e=(p>>>16)+(c>>>16)+(d>>>16)+(_>>>16)+(Q>>>16)+(s>>>16))<<16|65535&s,u=i<<16|65535&t,t=(65535&D)+(65535&x),s=(65535&f)+(65535&$)+((i=(D>>>16)+(x>>>16)+(t>>>16))>>>16),p=(e=(f>>>16)+($>>>16)+(s>>>16))<<16|65535&s,y=i<<16|65535&t,t=(65535&M)+(65535&u),s=(65535&V)+(65535&c)+((i=(M>>>16)+(u>>>16)+(t>>>16))>>>16),Q=(e=(V>>>16)+(c>>>16)+(s>>>16))<<16|65535&s,X=i<<16|65535&t,t=(65535&y)+(65535&u),s=(65535&p)+(65535&c)+((i=(y>>>16)+(u>>>16)+(t>>>16))>>>16),V=(e=(p>>>16)+(c>>>16)+(s>>>16))<<16|65535&s,M=i<<16|65535&t;t=(65535&w)+(65535&M),s=(65535&v)+(65535&V)+((i=(w>>>16)+(M>>>16)+(t>>>16))>>>16),e=(v>>>16)+(V>>>16)+(s>>>16),this.h0h=e<<16|65535&s,this.h0l=i<<16|65535&t,t=(65535&U)+(65535&W),s=(65535&S)+(65535&T)+((i=(U>>>16)+(W>>>16)+(t>>>16))>>>16),e=(S>>>16)+(T>>>16)+(s>>>16),this.h1h=e<<16|65535&s,this.h1l=i<<16|65535&t,t=(65535&k)+(65535&q),s=(65535&g)+(65535&Y)+((i=(k>>>16)+(q>>>16)+(t>>>16))>>>16),e=(g>>>16)+(Y>>>16)+(s>>>16),this.h2h=e<<16|65535&s,this.h2l=i<<16|65535&t,t=(65535&O)+(65535&L),s=(65535&z)+(65535&G)+((i=(O>>>16)+(L>>>16)+(t>>>16))>>>16),e=(z>>>16)+(G>>>16)+(s>>>16),this.h3h=e<<16|65535&s,this.h3l=i<<16|65535&t,t=(65535&J)+(65535&X),s=(65535&N)+(65535&Q)+((i=(J>>>16)+(X>>>16)+(t>>>16))>>>16),e=(N>>>16)+(Q>>>16)+(s>>>16),this.h4h=e<<16|65535&s,this.h4l=i<<16|65535&t,t=(65535&m)+(65535&FF),s=(65535&j)+(65535&Z)+((i=(m>>>16)+(FF>>>16)+(t>>>16))>>>16),e=(j>>>16)+(Z>>>16)+(s>>>16),this.h5h=e<<16|65535&s,this.h5l=i<<16|65535&t,t=(65535&I)+(65535&Fx),s=(65535&H)+(65535&F$)+((i=(I>>>16)+(Fx>>>16)+(t>>>16))>>>16),e=(H>>>16)+(F$>>>16)+(s>>>16),this.h6h=e<<16|65535&s,this.h6l=i<<16|65535&t,t=(65535&K)+(65535&Fh),s=(65535&R)+(65535&F_)+((i=(K>>>16)+(Fh>>>16)+(t>>>16))>>>16),e=(R>>>16)+(F_>>>16)+(s>>>16),this.h7h=e<<16|65535&s,this.h7l=i<<16|65535&t},E.prototype.hex=function(){this.finalize();var F=this.h0h,$=this.h0l,x=this.h1h,_=this.h1l,h=this.h2h,t=this.h2l,i=this.h3h,e=this.h3l,r=this.h4h,n=this.h4l,l=this.h5h,o=this.h5l,B=this.h6h,a=this.h6l,A=this.h7h,C=this.h7l,E=this.bits,f=s[F>>28&15]+s[F>>24&15]+s[F>>20&15]+s[F>>16&15]+s[F>>12&15]+s[F>>8&15]+s[F>>4&15]+s[15&F]+s[$>>28&15]+s[$>>24&15]+s[$>>20&15]+s[$>>16&15]+s[$>>12&15]+s[$>>8&15]+s[$>>4&15]+s[15&$]+s[x>>28&15]+s[x>>24&15]+s[x>>20&15]+s[x>>16&15]+s[x>>12&15]+s[x>>8&15]+s[x>>4&15]+s[15&x]+s[_>>28&15]+s[_>>24&15]+s[_>>20&15]+s[_>>16&15]+s[_>>12&15]+s[_>>8&15]+s[_>>4&15]+s[15&_]+s[h>>28&15]+s[h>>24&15]+s[h>>20&15]+s[h>>16&15]+s[h>>12&15]+s[h>>8&15]+s[h>>4&15]+s[15&h]+s[t>>28&15]+s[t>>24&15]+s[t>>20&15]+s[t>>16&15]+s[t>>12&15]+s[t>>8&15]+s[t>>4&15]+s[15&t]+s[i>>28&15]+s[i>>24&15]+s[i>>20&15]+s[i>>16&15]+s[i>>12&15]+s[i>>8&15]+s[i>>4&15]+s[15&i];return E>=256&&(f+=s[e>>28&15]+s[e>>24&15]+s[e>>20&15]+s[e>>16&15]+s[e>>12&15]+s[e>>8&15]+s[e>>4&15]+s[15&e]),E>=384&&(f+=s[r>>28&15]+s[r>>24&15]+s[r>>20&15]+s[r>>16&15]+s[r>>12&15]+s[r>>8&15]+s[r>>4&15]+s[15&r]+s[n>>28&15]+s[n>>24&15]+s[n>>20&15]+s[n>>16&15]+s[n>>12&15]+s[n>>8&15]+s[n>>4&15]+s[15&n]+s[l>>28&15]+s[l>>24&15]+s[l>>20&15]+s[l>>16&15]+s[l>>12&15]+s[l>>8&15]+s[l>>4&15]+s[15&l]+s[o>>28&15]+s[o>>24&15]+s[o>>20&15]+s[o>>16&15]+s[o>>12&15]+s[o>>8&15]+s[o>>4&15]+s[15&o]),512==E&&(f+=s[B>>28&15]+s[B>>24&15]+s[B>>20&15]+s[B>>16&15]+s[B>>12&15]+s[B>>8&15]+s[B>>4&15]+s[15&B]+s[a>>28&15]+s[a>>24&15]+s[a>>20&15]+s[a>>16&15]+s[a>>12&15]+s[a>>8&15]+s[a>>4&15]+s[15&a]+s[A>>28&15]+s[A>>24&15]+s[A>>20&15]+s[A>>16&15]+s[A>>12&15]+s[A>>8&15]+s[A>>4&15]+s[15&A]+s[C>>28&15]+s[C>>24&15]+s[C>>20&15]+s[C>>16&15]+s[C>>12&15]+s[C>>8&15]+s[C>>4&15]+s[15&C]),f},E.prototype.toString=E.prototype.hex,E.prototype.digest=function(){this.finalize();var F=this.h0h,$=this.h0l,x=this.h1h,_=this.h1l,h=this.h2h,t=this.h2l,i=this.h3h,s=this.h3l,e=this.h4h,r=this.h4l,n=this.h5h,l=this.h5l,o=this.h6h,B=this.h6l,a=this.h7h,A=this.h7l,C=this.bits,E=[F>>24&255,F>>16&255,F>>8&255,255&F,$>>24&255,$>>16&255,$>>8&255,255&$,x>>24&255,x>>16&255,x>>8&255,255&x,_>>24&255,_>>16&255,_>>8&255,255&_,h>>24&255,h>>16&255,h>>8&255,255&h,t>>24&255,t>>16&255,t>>8&255,255&t,i>>24&255,i>>16&255,i>>8&255,255&i];return C>=256&&E.push(s>>24&255,s>>16&255,s>>8&255,255&s),C>=384&&E.push(e>>24&255,e>>16&255,e>>8&255,255&e,r>>24&255,r>>16&255,r>>8&255,255&r,n>>24&255,n>>16&255,n>>8&255,255&n,l>>24&255,l>>16&255,l>>8&255,255&l),512==C&&E.push(o>>24&255,o>>16&255,o>>8&255,255&o,B>>24&255,B>>16&255,B>>8&255,255&B,a>>24&255,a>>16&255,a>>8&255,255&a,A>>24&255,A>>16&255,A>>8&255,255&A),E},E.prototype.array=E.prototype.digest,E.prototype.arrayBuffer=function(){this.finalize();var F=this.bits,$=new ArrayBuffer(F/8),x=new DataView($);return x.setUint32(0,this.h0h),x.setUint32(4,this.h0l),x.setUint32(8,this.h1h),x.setUint32(12,this.h1l),x.setUint32(16,this.h2h),x.setUint32(20,this.h2l),x.setUint32(24,this.h3h),F>=256&&x.setUint32(28,this.h3l),F>=384&&(x.setUint32(32,this.h4h),x.setUint32(36,this.h4l),x.setUint32(40,this.h5h),x.setUint32(44,this.h5l)),512==F&&(x.setUint32(48,this.h6h),x.setUint32(52,this.h6l),x.setUint32(56,this.h7h),x.setUint32(60,this.h7l)),$},E.prototype.clone=function(){var F=new E(this.bits,!1);return this.copyTo(F),F},E.prototype.copyTo=function(F){var $=0,x=["h0h","h0l","h1h","h1l","h2h","h2l","h3h","h3l","h4h","h4l","h5h","h5l","h6h","h6l","h7h","h7l","start","bytes","hBytes","finalized","hashed","lastByteIndex"];for($=0;$<x.length;++$)F[x[$]]=this[x[$]];for($=0;$<this.blocks.length;++$)F.blocks[$]=this.blocks[$]},f.prototype=new E,f.prototype.finalize=function(){if(E.prototype.finalize.call(this),this.inner){this.inner=!1;var F=this.array();E.call(this,this.bits,this.sharedMemory),this.update(this.oKeyPad),this.update(F),E.prototype.finalize.call(this)}},f.prototype.clone=function(){var F=new f([],this.bits,!1);this.copyTo(F),F.inner=this.inner;for(var $=0;$<this.oKeyPad.length;++$)F.oKeyPad[$]=this.oKeyPad[$];return F};var D=a(512);D.sha512=D,D.sha384=a(384),D.sha512_256=a(256),D.sha512_224=a(224),D.sha512.hmac=C(512),D.sha384.hmac=C(384),D.sha512_256.hmac=C(256),D.sha512_224.hmac=C(224),h?module.exports=D:(x.sha512=D.sha512,x.sha384=D.sha384,x.sha512_256=D.sha512_256,x.sha512_224=D.sha512_224,t&&define(function(){return D}))}();
