webpackJsonp([1,2],{

/***/ 122:
/***/ (function(module, exports) {

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  scopeId,
  cssModules
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  // inject cssModules
  if (cssModules) {
    var computed = options.computed || (options.computed = {})
    Object.keys(cssModules).forEach(function (key) {
      var module = cssModules[key]
      computed[key] = function () { return module }
    })
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 125:
/***/ (function(module, exports, __webpack_require__) {


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__(146);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', __webpack_require__(150));
//Vue.component('possessionCreate', require('./components/PossessionCreate.vue'));
Vue.component('possessions', __webpack_require__(151));

var app = new Vue({
  el: '#app'
});

/***/ }),

/***/ 126:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 144:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
    mounted: function mounted() {
        console.log('Component mounted.');
    }
};

/***/ }),

/***/ 145:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_moment__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_moment__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = {
  data: function data() {
    return {
      possessions: [],
      form: {
        title: '',
        description: ''
      }
    };
  },


  filters: {
    ago: function ago(date) {
      return __WEBPACK_IMPORTED_MODULE_0_moment___default()(date).fromNow();
    }
  },

  methods: {
    create: function create() {
      var _this = this;

      axios.post('/possession/store', this.form).then(function (response) {
        console.log(response);
        console.log(_this.form);
        _this.possessions.unshift(_this.form);
        _this.form = {
          title: '',
          description: ''
        };
        $('#collapse').collapse('hide');
      });
    }
  },

  created: function created() {
    var _this2 = this;

    axios.get('/possession/all/byUser').then(function (response) {
      _this2.possessions = response.data;
    });
  }
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(2)))

/***/ }),

/***/ 146:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(__webpack_provided_window_dot_jQuery) {
window._ = __webpack_require__(7);

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = __webpack_provided_window_dot_jQuery = __webpack_require__(2);

__webpack_require__(6);

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = __webpack_require__(8);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__(5);

window.axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest'
};

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(2)))

/***/ }),

/***/ 147:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(148)();
// imports


// module
exports.push([module.i, "\n.collapse.possession-create.collapsing {\n  -webkit-transition: none;\n  transition: none;\n}\nul.possessions .close {\n  font-size: 14px;\n}\nul.possessions h4 {\n  margin-bottom: 4px;\n}\nul.possessions .tags .label {\n  font-size: 14px;\n  margin-right: 3px;\n}\nul.possessions .shared li {\n  padding-left: 0;\n  padding-right: 0;\n}\nul.possessions .shared li img {\n    border-radius: 50%;\n    height: 35px;\n    width: 35px;\n}\nul.possessions .attach {\n  margin-top: 10px;\n  margin-bottom: 20px;\n}\nul.possessions .attach li {\n    padding-left: 2;\n    padding-right: 2;\n}\n", ""]);

// exports


/***/ }),

/***/ 148:
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function() {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		var result = [];
		for(var i = 0; i < this.length; i++) {
			var item = this[i];
			if(item[2]) {
				result.push("@media " + item[2] + "{" + item[1] + "}");
			} else {
				result.push(item[1]);
			}
		}
		return result.join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};


/***/ }),

/***/ 150:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(122)(
  /* script */
  __webpack_require__(144),
  /* template */
  __webpack_require__(153),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/abarron/Documents/projects/bb.dev/resources/assets/js/components/Example.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Example.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-81037772", Component.options)
  } else {
    if (module.hot.data.cssModules && JSON.stringify(module.hot.data.cssModules) !== JSON.stringify(cssModules)) {
      delete Component.options._Ctor
    }
    hotAPI.reload("data-v-81037772", Component.options)
  }
  module.hot.dispose(function (data) {
    data.cssModules = cssModules
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 151:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(154)

var Component = __webpack_require__(122)(
  /* script */
  __webpack_require__(145),
  /* template */
  __webpack_require__(152),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/abarron/Documents/projects/bb.dev/resources/assets/js/components/Possessions.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Possessions.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4916dbce", Component.options)
  } else {
    if (module.hot.data.cssModules && JSON.stringify(module.hot.data.cssModules) !== JSON.stringify(cssModules)) {
      delete Component.options._Ctor
    }
    hotAPI.reload("data-v-4916dbce", Component.options)
  }
  module.hot.dispose(function (data) {
    data.cssModules = cssModules
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 152:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "container"
  }, [_c('div', {
    staticClass: "collapse possession-create",
    attrs: {
      "id": "collapse"
    }
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-12"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "panel-body"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-12"
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.title),
      expression: "form.title"
    }],
    staticClass: "form-control input-lg",
    attrs: {
      "type": "text",
      "placeholder": "Car, House, Account..."
    },
    domProps: {
      "value": _vm._s(_vm.form.title)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.title = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.description),
      expression: "form.description"
    }],
    staticClass: "form-control",
    attrs: {
      "rows": "3",
      "placeholder": "This possesions is..."
    },
    domProps: {
      "value": _vm._s(_vm.form.description)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.description = $event.target.value
      }
    }
  })])]), _vm._v(" "), _vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "col-md-12 text-right"
  }, [_c('button', {
    staticClass: "btn btn-default",
    attrs: {
      "type": "button",
      "data-toggle": "collapse",
      "data-target": "#collapse"
    }
  }, [_vm._v("Cancel")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-success",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.create
    }
  }, [_vm._v("Create")])])])])])])])]), _vm._v(" "), _c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-12"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "panel-body"
  }, [_c('ul', {
    staticClass: "list-unstyled possessions"
  }, _vm._l((_vm.possessions), function(item) {
    return _c('li', [_c('div', {
      staticClass: "row"
    }, [_c('div', {
      staticClass: "col-md-12"
    }, [_vm._m(2, true), _vm._v(" "), _c('h4', [_vm._v(_vm._s(item.title))]), _vm._v(" "), _c('p', [_c('small', [_vm._v(_vm._s(item.description))])])]), _vm._v(" "), _c('div', {
      staticClass: "col-md-6 tags"
    }, [_vm._l((item.tags), function(tag) {
      return _c('span', {
        staticClass: "label label-info"
      }, [_vm._v(_vm._s(tag.title))])
    }), _vm._v(" "), _vm._m(3, true), _vm._v(" "), _vm._m(4, true)], 2), _vm._v(" "), _vm._m(5, true)]), _vm._v(" "), _c('div', {
      staticClass: "row attach"
    }, [_vm._m(6, true), _vm._v(" "), _c('div', {
      staticClass: "col-md-2 text-right"
    }, [_c('p', {
      staticClass: "text-muted"
    }, [_c('small', [_vm._v(_vm._s(_vm._f("ago")(item.created_at)))])])])]), _vm._v(" "), _c('hr')])
  }))])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-md-6 tags"
  }, [_c('a', {
    staticClass: "btn btn-sm",
    attrs: {
      "href": "#"
    }
  }, [_c('span', {
    staticClass: "glyphicon glyphicon-tag"
  }), _vm._v(" Tag")]), _vm._v(" "), _c('a', {
    staticClass: "btn btn-sm",
    attrs: {
      "href": "#"
    }
  }, [_c('span', {
    staticClass: "glyphicon glyphicon-paperclip"
  }), _vm._v(" Attach")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-md-6 shared"
  }, [_c('ul', {
    staticClass: "list-inline shared text-right"
  }, [_c('li', [_c('a', {
    staticClass: "btn btn-sm",
    attrs: {
      "href": "#"
    }
  }, [_c('span', {
    staticClass: "glyphicon glyphicon-share-alt"
  }), _vm._v(" Shared")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('button', {
    staticClass: "close",
    attrs: {
      "type": "button",
      "aria-label": "Close"
    }
  }, [_c('span', {
    staticClass: "glyphicon glyphicon-trash",
    attrs: {
      "aria-hidden": "true"
    }
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "btn btn-sm",
    attrs: {
      "href": "#"
    }
  }, [_c('span', {
    staticClass: "glyphicon glyphicon-tag"
  }), _vm._v(" Tag")])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "btn btn-sm",
    attrs: {
      "href": "#"
    }
  }, [_c('span', {
    staticClass: "glyphicon glyphicon-paperclip"
  }), _vm._v(" Attach")])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-md-6 shared"
  }, [_c('ul', {
    staticClass: "list-inline shared text-right"
  }, [_c('li', [_c('a', {
    staticClass: "btn btn-sm",
    attrs: {
      "href": "#"
    }
  }, [_c('span', {
    staticClass: "glyphicon glyphicon-share-alt"
  }), _vm._v(" Shared")])]), _vm._v(" "), _c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/people/1",
      "alt": ""
    }
  })]), _vm._v(" "), _c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/people/2",
      "alt": ""
    }
  })]), _vm._v(" "), _c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/people/3",
      "alt": ""
    }
  })]), _vm._v(" "), _c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/people/4",
      "alt": ""
    }
  })])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-md-10"
  }, [_c('ul', {
    staticClass: "list-inline"
  }, [_c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/business/1",
      "alt": ""
    }
  })]), _vm._v(" "), _c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/business/2",
      "alt": ""
    }
  })]), _vm._v(" "), _c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/business/3",
      "alt": ""
    }
  })]), _vm._v(" "), _c('li', [_c('img', {
    attrs: {
      "src": "http://lorempixel.com/48/48/business/4",
      "alt": ""
    }
  })])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-4916dbce", module.exports)
  }
}

/***/ }),

/***/ 153:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _vm._m(0)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "container"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-8 col-md-offset-2"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "panel-heading"
  }, [_vm._v("Example Component")]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_vm._v("\n                    I'm an example component!\n                ")])])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-81037772", module.exports)
  }
}

/***/ }),

/***/ 154:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(147);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(155)("23ab126c", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!./../../../../node_modules/css-loader/index.js!./../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-4916dbce!./../../../../node_modules/sass-loader/index.js!./../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Possessions.vue", function() {
     var newContent = require("!!./../../../../node_modules/css-loader/index.js!./../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-4916dbce!./../../../../node_modules/sass-loader/index.js!./../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Possessions.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 155:
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(156)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = { css: css, media: media, sourceMap: sourceMap }
    if (!newStyles[id]) {
      part.id = parentId + ':0'
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      part.id = parentId + ':' + newStyles[id].parts.length
      newStyles[id].parts.push(part)
    }
  }
  return styles
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')
  var hasSSR = styleElement != null

  // if in production mode and style is already provided by SSR,
  // simply do nothing.
  if (hasSSR && isProduction) {
    return noop
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = styleElement || createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (!hasSSR) {
    update(obj)
  }

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ 156:
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),

/***/ 157:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(125);
module.exports = __webpack_require__(126);


/***/ })

},[157]);