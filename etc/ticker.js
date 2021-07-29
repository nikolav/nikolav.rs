// ticker.js
// author      : vukovic nikola
// description : .setTimeout() wrapper
// email       : admin@nikolav.rs
// gh          : https://github.com/nikolav/ticker-js
// license     : public
!function(context,name,def,globals){context[name]=def(globals)}(window,"ticker",(function(globals,none){var clearTimeout=globals.clearTimeout,Date=globals.Date,Object=globals.Object,pArray=globals.Array.prototype,parseFloat=globals.parseFloat,pFunction=globals.Function.prototype,pObject=globals.Object.prototype,setTimeout=globals.setTimeout,call_=pFunction.call,bind_="bind"in pFunction?call_.bind(pFunction.bind):function(func,context){if(context&&isfunc(func))return function(){return func.apply(context,arguments)};err()},OFF=!1,ON=!0,cls=bind_(call_,pObject.toString),hasown=bind_(call_,pObject.hasOwnProperty),mathAbs=globals.Math.abs,slice=bind_(call_,pArray.slice),defaults={fq:1e3,rc:1/0},datenow=Date.now||function(){return+new Date},pnow=function(tmstart,datenow,globals){return"now"in Object(globals.performance)?bind_(globals.performance.now,globals.performance):(tmstart=datenow(),function(){return datenow()-tmstart})}(none,datenow,globals),stateinfo={currentcount:"cc",delay:"fq",repeatcount:"rc",running:"on"},class2str_object=cls(stateinfo),pTicker=Ticker.prototype;return paste(pTicker,{_:none,destroy:destroy_,reset:reset_,start:start_,state:state_,stop:stop_,tick:tick_}),paste((function(delay,repeatcount){return new Ticker(delay,repeatcount)}),{defaults:defaults,fn:pTicker,Ticker:Ticker});function Ticker(){this._=newstate(this,arguments)}function absfloat(number){return parseFloat(mathAbs(number))}function async(func){return function(){var arguments_=arguments,self=this;return setTimeout((function(){func.apply(self,arguments_)})),self}}function cbtick(){var _=this._;_.cc+=1,_.cb.call(_.cx,tdata(this)),_.cc<_.rc?_.ti=setTimeout(_.tt,_.fq):_.z0()}function destroy_(){reset_.call(this)._=none}function err(){throw Error}function fn1(){return 1}function isarraylike(node){try{return 0<=node.length&&fn1.apply(this,node)&&!isfunc(node)}catch(e){}return 0}function isfunc(node){return"function"==typeof node}function isplainobj(node){return class2str_object===cls(node)}function newstate(self,arguments_){return{cb:none,cc:0,cx:self,fq:absfloat(arguments_[0])||defaults.fq,ls:[],on:!1,rc:absfloat(arguments_[1])||defaults.rc,ti:none,ts:none,tt:bind_(cbtick,self),z0:bind_(zer0cc,self)}}function owneach(object,callback,context){for(var field in object)hasown(object,field)&&callback.call(context,object[field],field,object);return object}function paste(target,items){for(var field in items)hasown(items,field)&&(target[field]=items[field]);return target}function reset_(){return clearTimeout(this._.ti),this._.z0(),this}function start_(setup){var _=this._,a=arguments;return!_.on&&isfunc(_.cb)&&(_.on=!0,(setup=a.length?isplainobj(setup)?setup:{args:slice(a,0)}:{}).context&&(_.cx=setup.context),hasown(setup,"args")&&(_.ls=isarraylike(setup.args)?setup.args:[setup.args]),_.cc+=1,_.ts=pnow(),async(_.cb).call(_.cx,tdata(this)),_.cc<_.rc?_.ti=setTimeout(_.tt,_.fq):async(_.z0)()),this}function state_(){var st={};return owneach(stateinfo,statecp,{st:st,node:this}),st}function statecp(alias,field){this.st[field]=this.node._[alias]}function stop_(){var _=this._;return _.on&&(clearTimeout(_.ti),_.ti=none,_.on=!1),this}function tdata(self){return{data:self._.ls,start:self._.ts,time:pnow()}}function tick_(func){return this._.cb=func,this}function zer0cc(){var _=this._;_.cc=0,_.ti=none,_.on=!1}}),new Function("return this;")());
