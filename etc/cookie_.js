// #cookie
window['cookie_'] = 
(function (none) {

  var cookie;
  
  var cdefaults = {
  	  'domain'   : none
    , 'path'     : '/'
    , 'expires'  : 30 //days
    , 'Secure'   : none
    , 'SameSite' : 'Strict'
  };

  //var MAX_COOKIE_LENGTH = 3950;
  
  var compec;
  var compdc      = decodeURIComponent;
  var corslice    = Function.prototype.call.bind(Array.prototype.slice);
  var jsdc        = JSON.parse;
  var jsec        = JSON.stringify;
  var rcookiesep  = /\s*;\s*/g;

  compec = _init(function ec (s) {
    // doesn't encode '_'
    return ec.c("" + s).replace(/[~'()!]/g, ec.s).replace(/[\-*.]/g, ec.f);
  }, {
    'c': encodeURIComponent,
    'f': (function (a) { return this[a]; }).bind({'*':'%2A','-':'%2D','.':'%2E'/*,'_':'%%%'*/}),
    's': window.escape});

  cookie = _init(function cookie_ (input, value, opt) {

    
    var al, xtm;
    
    if ((al = arguments.length)) {

      if (1 < al) {

        // write
        
        opt   = defs(ispo(opt) ? opt : {}, cdefaults);
        value = cookie_.json ? jsec(value) : (''+value);
        xtm   = new Date(Date.now() + 86400000 * parseFloat(opt.expires));
        
        return (document.cookie = [
          encodekey(input), '=', compec(value),
          opt.domain   ? ';domain='  + opt.domain : '',
          opt.path     ? ';path='    + opt.path : '',
          opt.expires  ? ';expires=' + xtm.toUTCString() : '',
          opt.Secure   ? ';Secure' : '',
          opt.SameSite ? ';SameSite=' + opt.SameSite : ''].join('')), cookie_;
      } else {
        if (ispo(input)) { 
          // merge
          return owneachbase(input, cbcookieset, opt || {}), cookie_;
        } else {
          // read
          return cookie_.fetch(input);
        }
      }
    } else {
      return cookie_.fetch();
    }
  }, {
    
    _parts: function () {
      var ls;
      return (ls = this.plaintxt()) && ls.split(rcookiesep) || [];
    }, 
    
    'defaults' : cdefaults,
    'json'     : true,
    'raw'      : false,
    
    'alter': function (input, opt) {
      return ispo(input) && 
        (this.clear(), owneachbase(input, cbcookieset, opt || {})), this;
    }, 
    'clear': function () {
      return this.ls().forEach(cbcookierm, {'expires': -30}), this;
    }, 
    'each': function  (callback, context) {
      each_break(this._parts(), cbcookieach, {
        'cb'  : callback, 
        'cx'  : context || document, 
        'dc'  : decode, 
        'dcp' : decodeparse
      });
      return this;
    }, 

    'fetch': function (key) {
      var _;
      return arguments.length ? 
        ((_ = {
          'cval' : none, 
          'dc'   : decode, 
          'dcp'  : decodeparse, 
          'key'  : ''+key}),
          each_break(this._parts(), cbcookieread, _),
          _.cval) : cobject();
    }, 
    'has': function (key) {
      return arguments.length ? 
        (this._parts().some(cbcookiehas, {'dc':decode,'key':''+key})) : 
        !!this.plaintxt();
    }, 
    'len' : function () {
      return this._parts().length;
    },
    'ls': function  () {
      return this._parts().map(cbcookiels);
    }, 
    'plaintxt': function () {
      return document.cookie || '';
    }, 
    'rm': function  () {
      return arguments.length && 
        intersect(corslice(arguments, 0), this.ls())
        .forEach(cbcookierm, {'expires': -30}), this;
    }
  });
  

  function _init (node, source) {
    var name;
    for ( name in source ) {
      if (source.hasOwnProperty(name))
        node[name] = source[name];
    }
    return node;
  }

  function cbcookieach (part) {
    var _ = this;
    return (part = part.split('=')), 
      _.cb.call(_.cx, _.dc(part[0]), _.dcp(part[1]));
  }

  function cbcookieread (parts) {
    return (this.key == this.dc((parts = parts.split('='))[0])) ? 
      ((this.cval = this.dcp(parts[1])), false) : 1;
  }
  
  function cbcookierm (field) {
    cookie(field, '', this);
  }
  
  function cbcookieset (cfield, cvalue) {
    cookie(cfield, cvalue, this);
  }
  
  function cbcookiels (part) {
    return decode(part.split('=')[0]);
  }
  
  function encodekey (input) {
    return (input += ""), cookie.raw ? input : compec(input);
  }
  
  function cobject () {
    
    var obj = {};
    
    return cookie._parts().forEach(cbcookieparse, obj), obj;
  }
  
  function decode (s) {
    return cookie.raw ? s : compdc(s);
  }
  
  function decodeparse (cvalue) {
    
    cvalue = (''+cvalue).replace(/^"([\s\S]+)"$/, cbdecodereplace);
    
    try {
      return (cvalue = decode(cvalue)),
        cookie.json ? jsdc(cvalue) : cvalue;
    } catch (e) {}
    
    return null;
  }
  
  function cbcookieparse (parts) {
    parts = parts.split('=');
    this[(decode(parts[0]))] = decodeparse(parts[1]);
  }
      
  function cbdecodereplace (all, _1) {
    return _1.repa('\\"', '"').repa('\\\\', '\\');
  }
  
  function cbcookiehas (parts) {
    return this.key == this.dc(parts.split('=')[0]);
  }
  function owneachbase (node, callback, context) {
    
    var name;
    var ctx = context || node;

    for (name in node) {
      if (node.hasOwnProperty(name)) {
        callback.call(ctx, name, node[name], node);
      }
    }

    return node;
  }
  function defs (node, defaults) {
    return owneachbase (defaults, cbdefs, node), node;
  }
  function cbdefs (dk, dv) {
    if (!this.hasOwnProperty(dk))
      this[dk] = dv;
  }
  function each_break (ls, callback, context) {

    for (
    var 
      i   = 0, 
      l   = ls.length, 
      ctx = context || ls; 

    i < l; 
    i++) {
      if (false === callback.call(ctx, ls[i], i, ls)) 
        break;
    }

    return ls;
  }

  function intersect (ls1, ls2) {
    var intersection = [];
    ls2.forEach(cbintersect, {
      'i'   : intersection, 
      'ls1' : ls1});
    return intersection;
  }
  function cbintersect (lv) {
    // .push unique
    if ( ( -1 != this.ls1.indexOf(lv) ) && ( -1 == this.i.indexOf(lv) ) )
      this.i.push(lv);
  }

  function ispo (node) {
    return "[object Object]" == Object.prototype.toString.call(node);
  }

  return cookie;
})();
