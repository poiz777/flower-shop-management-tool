(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["App"] = factory();
	else
		root["App"] = factory();
})(this, function() {
return (this["webpackJsonpApp"] = this["webpackJsonpApp"] || []).push([[0],{

/***/ 15:
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(6);

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(17)(content, options);

if(content.locals) module.exports = content.locals;

if(true) {
	module.hot.accept(6, function() {
		var newContent = __webpack_require__(6);

		if(typeof newContent === 'string') newContent = [[module.i, newContent, '']];

		var locals = (function(a, b) {
			var key, idx = 0;

			for(key in a) {
				if(!b || a[key] !== b[key]) return false;
				idx++;
			}

			for(key in b) idx--;

			return idx === 0;
		}(content.locals, newContent.locals));

		if(!locals) throw new Error('Aborting CSS HMR due to changed css-modules locals.');

		update(newContent);
	});

	module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 19:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/esm/classCallCheck.js
var classCallCheck = __webpack_require__(1);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/esm/createClass.js
var createClass = __webpack_require__(2);

// EXTERNAL MODULE: ./node_modules/react/index.js
var react = __webpack_require__(0);
var react_default = /*#__PURE__*/__webpack_require__.n(react);

// EXTERNAL MODULE: ./node_modules/react-dom/index.js
var react_dom = __webpack_require__(8);
var react_dom_default = /*#__PURE__*/__webpack_require__.n(react_dom);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/esm/possibleConstructorReturn.js + 2 modules
var possibleConstructorReturn = __webpack_require__(4);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/esm/getPrototypeOf.js
var getPrototypeOf = __webpack_require__(3);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/esm/inherits.js + 1 modules
var inherits = __webpack_require__(5);

// EXTERNAL MODULE: ./src/DropDownWidget.css
var src_DropDownWidget = __webpack_require__(15);

// CONCATENATED MODULE: ./src/Indicator.js





var _jsxFileName = "/Users/poiz/web_stack/full_stack/APPS/REACT/drop-down/src/Indicator.js";


var Indicator_Indicator =
/*#__PURE__*/
function (_Component) {
  Object(inherits["a" /* default */])(Indicator, _Component);

  function Indicator() {
    Object(classCallCheck["a" /* default */])(this, Indicator);

    return Object(possibleConstructorReturn["a" /* default */])(this, Object(getPrototypeOf["a" /* default */])(Indicator).apply(this, arguments));
  }

  Object(createClass["a" /* default */])(Indicator, [{
    key: "render",
    value: function render() {
      var _this = this;

      return react_default.a.createElement("span", {
        className: "pz-drop-down-indicator",
        onClick: function onClick(e) {
          _this.props.showAllSuggestions(e);
        },
        __source: {
          fileName: _jsxFileName,
          lineNumber: 7
        },
        __self: this
      }, react_default.a.createElement("div", {
        className: "pz-arrow-down",
        __source: {
          fileName: _jsxFileName,
          lineNumber: 9
        },
        __self: this
      }));
    }
  }]);

  return Indicator;
}(react["Component"]);

/* harmony default export */ var src_Indicator = (Indicator_Indicator);
// CONCATENATED MODULE: ./src/DropDownWidget.js





var DropDownWidget_jsxFileName = "/Users/poiz/web_stack/full_stack/APPS/REACT/drop-down/src/DropDownWidget.js";




var DropDownWidget_DropDownWidget =
/*#__PURE__*/
function (_Component) {
  Object(inherits["a" /* default */])(DropDownWidget, _Component);

  function DropDownWidget(props) {
    var _this;

    Object(classCallCheck["a" /* default */])(this, DropDownWidget);

    _this = Object(possibleConstructorReturn["a" /* default */])(this, Object(getPrototypeOf["a" /* default */])(DropDownWidget).call(this, props));
    _this.inputRefs = {
      dropDown: react_default.a.createRef(),
      dropDownOptions: react_default.a.createRef(),
      mainValField: react_default.a.createRef(),
      pzDropDownWrapper: react_default.a.createRef()
    };
    _this.state = {
      dropDownChildren: '',
      ignoredKeySuffix: _this.props.jsonData.ignoredKeySuffix,
      replaceInKeyRx: _this.props.jsonData.replaceInKeyRx
    };
    return _this;
  }

  Object(createClass["a" /* default */])(DropDownWidget, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this2 = this;

      /**
       * HIDE DROP-DOWN LIST OF SUGGESTED TERMS
       * WHEN YOU CLICK OUTSIDE THE ENTIRE WIDGET...
       * THIS IS A WORKAROUND FOR ON-CLICK-OUTSIDE EVENT
       * THAT I CONJURED UP ON THE FLY...
       * FEEL FREE TO IMPLEMENT A BETTER ONE IF YOU KNOW ANY ;-)
       */
      document.addEventListener('click', function (e) {
        var ddWrapper = _this2.inputRefs.pzDropDownWrapper.current;

        if (!ddWrapper.contains(e.target)) {
          _this2.removeSuggestedChildren(e);
        }
      });
      var defVal = this.props.jsonData.defaultValue; // console.log(defVal);

      for (var key in this.props.jsonData.suggestions) {
        var objVal = this.props.jsonData.suggestions[key];

        if (typeof key === 'string') {
          if (key.trim() === (defVal + "").trim()) {
            this.inputRefs.dropDown.current.value = objVal.trim();
            break;
          }
        } else {
          if (parseInt(key) === parseInt(defVal)) {
            this.inputRefs.dropDown.current.value = objVal.trim();
            break;
          }
        }
      } // console.log(this.inputRefs.dropDown.current);

    }
    /**
     * BASED ON THE ENTERED TEXT ON THE MAIN INPUT FIELD,
     * THIS FILTERS THE RELEVANT MATCHES AND UPDATES THE RENDERED DROP-DOWN LIST
     * @param e
     * @returns {boolean}
     */

  }, {
    key: "updateDropDown",
    value: function updateDropDown(e) {
      e.preventDefault();
      var suggestions = this.props.jsonData.suggestions;
      var searchTerm = this.inputRefs.dropDown.current.value;
      var rxSearch = new RegExp(searchTerm, 'gi');
      var matches = [];

      if (Object.keys(suggestions) && !suggestions.length) {
        matches = {}; // WE ARE DEALING WITH AN OBJECT NOT ARRAY:

        for (var suggestionKey in suggestions) {
          var suggestion = suggestions[suggestionKey];

          if (rxSearch.test(suggestion)) {
            matches[suggestionKey] = suggestion.trim();
          }
        }
      } else {
        suggestions.forEach(function (suggestion) {
          if (rxSearch.test(suggestion)) {
            matches.push(suggestion);
          }
        });
      }

      if (matches.length < 1) {
        this.inputRefs.dropDown.current.value = '';
        this.inputRefs.mainValField.current.value = '';
        return false;
      }

      this.renderDropDownChildren(matches);
    }
    /**
     * UPDATES THE MAIN INPUT FIELD...
     * INJECTS THE VALUE OF THE CURRENT ITEM-ON-FOCUS FROM WITHIN THE DROP-DOWN LIST
     * @param e
     */

  }, {
    key: "updateMainTextFieLdValue",
    value: function updateMainTextFieLdValue(e) {
      this.inputRefs.dropDown.current.value = e.target.value.trim();
      this.inputRefs.mainValField.current.value = e.target.getAttribute('data-value').trim();
    }
    /**
     * REMOVES THE VISIBLE LIST OF DROP-DOWN SUGGESTIONS.
     * @param e
     */

  }, {
    key: "removeSuggestedChildren",
    value: function removeSuggestedChildren(e) {
      var dropDownChildren = this.inputRefs.dropDownOptions.current;
      var dropDownClasses = dropDownChildren.getAttribute('class');

      if (dropDownClasses.indexOf('pz-show') !== -1) {
        dropDownClasses = dropDownClasses.replace('pz-show', 'pz-hide');
        dropDownChildren.setAttribute('class', dropDownClasses);
      }
    }
  }, {
    key: "handleChildKeyUp",
    value: function handleChildKeyUp(e) {}
  }, {
    key: "resetToNull",
    value: function resetToNull(e) {
      this.inputRefs.mainValField.current.value = '';
      this.inputRefs.dropDown.current.value = '';
      this.removeSuggestedChildren(e);
    }
  }, {
    key: "handleChildKeyDown",
    value: function handleChildKeyDown(e) {
      var targetField = e.target;
      var targetParent = targetField.parentNode;
      var keyCode = e.which || e.keyCode;

      switch (keyCode) {
        case 9:
          // TAB
          e.preventDefault();
          this.removeSuggestedChildren(e);
          break;

        case 13:
          // ENTER
          e.preventDefault();
          this.removeSuggestedChildren(e);
          break;

        case 38:
          // UP ARROW
          if (targetParent.previousSibling) {
            targetParent.previousSibling.children[0].focus();
          }

          break;

        case 40:
          // DOWN ARROW
          if (targetParent.nextSibling) {
            targetParent.nextSibling.children[0].focus();
          }

          break;

        default:
          break;
      }
    }
    /**
     * DISPLAYS ALL POSSIBLE SUGGESTIONS...
     * @param e
     */

  }, {
    key: "showAllSuggestions",
    value: function showAllSuggestions(e) {
      this.renderDropDownChildren(this.props.jsonData.suggestions);
      this.inputRefs.dropDown.current.focus();
    }
    /**
     * PREVENTS DEFAULT BEHAVIOUR FOR THE "TAB" & "ENTER" KEYS
     * @param e
     */

  }, {
    key: "selectOnTabOrEnter",

    /**
     * SELECTS AN ITEM ON THE DISPLAY LIST THAT HAS CURRENT FOCUS
     * WHEN THE TAB OR ENTER KEY IS PRESSED
     * @param e
     */
    value: function selectOnTabOrEnter(e) {
      DropDownWidget.preventTabAndEnterDefaults(e);
      var firstInputField;

      try {
        firstInputField = this.inputRefs.dropDownOptions.current.children[0].children[0];
      } catch (e) {
        this.resetToNull(e);
        return false;
      }

      var keyCode = e.which || e.keyCode;

      switch (keyCode) {
        case 9:
          // TAB
          this.inputRefs.dropDown.current.value = firstInputField.value;
          e.target.value = this.inputRefs.dropDown.current.value;
          this.inputRefs.mainValField.current.value = this.inputRefs.dropDown.current.getAttribute('data-value');
          firstInputField.focus();
          break;

        case 13:
          // ENTER
          break;

        case 38:
          // UP ARROW
          this.inputRefs.dropDown.current.value = firstInputField.value;
          e.target.value = this.inputRefs.dropDown.current.value;
          this.inputRefs.mainValField.current.value = this.inputRefs.dropDown.current.getAttribute('data-value');
          firstInputField.focus();
          break;

        case 40:
          // DOWN ARROW
          this.inputRefs.dropDown.current.value = firstInputField.value;
          e.target.value = this.inputRefs.dropDown.current.value;
          this.inputRefs.mainValField.current.value = this.inputRefs.dropDown.current.getAttribute('data-value');
          firstInputField.focus();
          break;

        default:
          break;
      }
    }
    /**
     * BUILDS THE SUGGESTION LIST BASED ON INPUT TEXT (MATCHED STRING)
     * @param matches
     */

  }, {
    key: "renderDropDownChildren",
    value: function renderDropDownChildren(matches) {
      var _this3 = this;

      var ddc;
      var key;
      var cue = 0;
      var dropDownChildren = this.inputRefs.dropDownOptions.current;
      var dropDownClasses = dropDownChildren.getAttribute('class');

      if (dropDownClasses.indexOf('pz-hide') !== -1) {
        dropDownClasses = dropDownClasses.replace('pz-hide', 'pz-show');
        dropDownChildren.setAttribute('class', dropDownClasses);
      }

      if (Object.keys(matches) && !matches.length) {
        // console.log(matches);
        // WE ARE DEALING WITH AN OBJECT NOT ARRAY:
        ddc = [];

        for (key in matches) {
          var cssClass = matches[key].trim() === this.inputRefs.dropDown.current.value || key.trim() === this.inputRefs.mainValField.current.value ? ' pz-is-selected' : '';
          cue++;

          if (this.state.ignoredKeySuffix) {
            if (new RegExp(this.state.ignoredKeySuffix).test(key.trim())) {
              ddc.push(react_default.a.createElement("div", {
                className: "pz-child-suggestion-box pz-null-action-box",
                key: "".concat(key.trim(), "-").concat(cue),
                __source: {
                  fileName: DropDownWidget_jsxFileName,
                  lineNumber: 255
                },
                __self: this
              }, react_default.a.createElement("input", {
                type: "text",
                readOnly: true,
                "data-value": key,
                className: "pz-suggestion-input".concat(cssClass),
                onFocus: function onFocus(e) {
                  _this3.resetToNull(e);
                },
                onClick: function onClick(e) {
                  _this3.resetToNull(e);
                },
                value: matches[key],
                __source: {
                  fileName: DropDownWidget_jsxFileName,
                  lineNumber: 256
                },
                __self: this
              })));
            } else {
              ddc.push(react_default.a.createElement("div", {
                className: "pz-child-suggestion-box",
                key: "".concat(key.trim(), "-").concat(cue),
                __source: {
                  fileName: DropDownWidget_jsxFileName,
                  lineNumber: 267
                },
                __self: this
              }, react_default.a.createElement("input", {
                type: "text",
                readOnly: true,
                "data-value": key,
                className: "pz-suggestion-input".concat(cssClass),
                onFocus: function onFocus(e) {
                  _this3.updateMainTextFieLdValue(e);
                },
                onClick: function onClick(e) {
                  _this3.removeSuggestedChildren(e);
                },
                onKeyUp: function onKeyUp(e) {
                  _this3.handleChildKeyUp(e);
                },
                onKeyDown: function onKeyDown(e) {
                  _this3.handleChildKeyDown(e);
                },
                value: matches[key],
                __source: {
                  fileName: DropDownWidget_jsxFileName,
                  lineNumber: 268
                },
                __self: this
              })));
            }
          } else {
            ddc.push(react_default.a.createElement("div", {
              className: "pz-child-suggestion-box",
              key: "".concat(key.trim(), "-").concat(cue),
              __source: {
                fileName: DropDownWidget_jsxFileName,
                lineNumber: 281
              },
              __self: this
            }, react_default.a.createElement("input", {
              type: "text",
              readOnly: true,
              "data-value": key,
              className: "pz-suggestion-input".concat(cssClass),
              onFocus: function onFocus(e) {
                _this3.updateMainTextFieLdValue(e);
              },
              onClick: function onClick(e) {
                _this3.removeSuggestedChildren(e);
              },
              onKeyUp: function onKeyUp(e) {
                _this3.handleChildKeyUp(e);
              },
              onKeyDown: function onKeyDown(e) {
                _this3.handleChildKeyDown(e);
              },
              value: matches[key],
              __source: {
                fileName: DropDownWidget_jsxFileName,
                lineNumber: 282
              },
              __self: this
            })));
          }
        }
      } else {
        ddc = matches.map(function (suggestion, cueKey) {
          return react_default.a.createElement("div", {
            className: "pz-child-suggestion-box",
            key: cueKey,
            __source: {
              fileName: DropDownWidget_jsxFileName,
              lineNumber: 299
            },
            __self: this
          }, react_default.a.createElement("input", {
            type: "text",
            readOnly: true,
            "data-value": suggestion.trim(),
            className: "pz-suggestion-input",
            onFocus: function onFocus(e) {
              _this3.updateMainTextFieLdValue(e);
            },
            onClick: function onClick(e) {
              _this3.removeSuggestedChildren(e);
            },
            onKeyUp: function onKeyUp(e) {
              _this3.handleChildKeyUp(e);
            },
            onKeyDown: function onKeyDown(e) {
              _this3.handleChildKeyDown(e);
            },
            value: suggestion.trim(),
            __source: {
              fileName: DropDownWidget_jsxFileName,
              lineNumber: 300
            },
            __self: this
          }));
        });
      }

      this.setState({
        dropDownChildren: ddc
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this4 = this;

      var defVal = this.props.jsonData.defaultValue;

      if (Object.keys(this.props.jsonData.suggestions) && !this.props.jsonData.suggestions.length) {
        defVal = this.props.jsonData.suggestions[this.props.jsonData.defaultValue];
      }

      return react_default.a.createElement("div", {
        className: "pz-drop-down-wrapper",
        ref: this.inputRefs.pzDropDownWrapper,
        __source: {
          fileName: DropDownWidget_jsxFileName,
          lineNumber: 325
        },
        __self: this
      }, react_default.a.createElement("div", {
        className: "pz-drop-down",
        __source: {
          fileName: DropDownWidget_jsxFileName,
          lineNumber: 326
        },
        __self: this
      }, react_default.a.createElement("input", {
        type: "text",
        id: this.props.jsonData.fieldName,
        className: this.props.jsonData.className,
        placeholder: this.props.jsonData.placeholder,
        autoComplete: "off",
        defaultValue: defVal,
        ref: this.inputRefs.dropDown,
        onChange: function onChange(e) {
          _this4.updateDropDown(e);
        },
        onKeyUp: function onKeyUp(e) {
          _this4.selectOnTabOrEnter(e);
        },
        onKeyDown: function onKeyDown(e) {
          DropDownWidget.preventTabAndEnterDefaults(e);
        },
        __source: {
          fileName: DropDownWidget_jsxFileName,
          lineNumber: 327
        },
        __self: this
      }), react_default.a.createElement(src_Indicator, {
        showAllSuggestions: function showAllSuggestions(e) {
          return _this4.showAllSuggestions(e);
        },
        __source: {
          fileName: DropDownWidget_jsxFileName,
          lineNumber: 337
        },
        __self: this
      }), react_default.a.createElement("input", {
        type: "hidden",
        name: this.props.jsonData.fieldName,
        ref: this.inputRefs.mainValField,
        defaultValue: this.props.jsonData.defaultValue,
        __source: {
          fileName: DropDownWidget_jsxFileName,
          lineNumber: 339
        },
        __self: this
      })), react_default.a.createElement("div", {
        className: "pz-drop-down-children pz-hide",
        ref: this.inputRefs.dropDownOptions,
        __source: {
          fileName: DropDownWidget_jsxFileName,
          lineNumber: 341
        },
        __self: this
      }, this.state.dropDownChildren));
    }
  }], [{
    key: "preventTabAndEnterDefaults",
    value: function preventTabAndEnterDefaults(e) {
      var keyCode = e.which || e.keyCode;

      if (keyCode === 9 || keyCode === 13) {
        e.preventDefault();
      }
    }
  }]);

  return DropDownWidget;
}(react["Component"]);

/* harmony default export */ var src_DropDownWidget_0 = (DropDownWidget_DropDownWidget);
// CONCATENATED MODULE: ./src/App.js





var App_jsxFileName = "/Users/poiz/web_stack/full_stack/APPS/REACT/drop-down/src/App.js";




var App_App =
/*#__PURE__*/
function (_Component) {
  Object(inherits["a" /* default */])(App, _Component);

  function App(props) {
    var _this;

    Object(classCallCheck["a" /* default */])(this, App);

    _this = Object(possibleConstructorReturn["a" /* default */])(this, Object(getPrototypeOf["a" /* default */])(App).call(this, props));
    _this._appData = null;
    _this.state = {};
    return _this;
  }

  Object(createClass["a" /* default */])(App, [{
    key: "render",
    value: function render() {
      return react_default.a.createElement("div", {
        __source: {
          fileName: App_jsxFileName,
          lineNumber: 16
        },
        __self: this
      }, react_default.a.createElement(src_DropDownWidget_0, {
        jsonData: this.props.jsonData,
        __source: {
          fileName: App_jsxFileName,
          lineNumber: 17
        },
        __self: this
      }));
    }
  }, {
    key: "appData",
    get: function get() {
      return this._appData;
    },
    set: function set(value) {
      this._appData = value;
    }
  }]);

  return App;
}(react["Component"]);

/* harmony default export */ var src_App = (App_App);
// CONCATENATED MODULE: ./src/Go.js


var Go_jsxFileName = "/Users/poiz/web_stack/full_stack/APPS/REACT/drop-down/src/Go.js";




var Go_PzRenderer =
/*#__PURE__*/
function () {
  function PzRenderer() {
    var domID = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var appData = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

    Object(classCallCheck["a" /* default */])(this, PzRenderer);

    this._domID = null;
    this._appData = null;
    this._domID = domID;
    this._appData = appData;
  }

  Object(createClass["a" /* default */])(PzRenderer, [{
    key: "renderToView",
    value: function renderToView() {
      var domID = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      var appData = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      this._domID = domID ? domID : this.domID;
      this._appData = appData ? appData : this.appData;
      react_dom_default.a.render(react_default.a.createElement(src_App, {
        jsonData: this.appData,
        __source: {
          fileName: Go_jsxFileName,
          lineNumber: 17
        },
        __self: this
      }), document.getElementById(this.domID));
    }
  }, {
    key: "domID",
    get: function get() {
      return this._domID;
    },
    set: function set(value) {
      this._domID = value;
    }
  }, {
    key: "appData",
    get: function get() {
      return this._appData;
    },
    set: function set(value) {
      this._appData = value;
    }
  }]);

  return PzRenderer;
}();

/* harmony default export */ var Go = __webpack_exports__["default"] = (Go_PzRenderer);

/***/ }),

/***/ 6:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(16)(false);
// imports


// module
exports.push([module.i, ".pz-drop-down-wrapper {\n    display: block;\n    margin: 0; /*50px 200px;*/\n    /*width: 21.2em;*/\n    padding: 0;\n}\n\n.pz-drop-down {\n    position: relative;\n    display: inline-block;\n}\n.pz-drop-down-field {\n    height: 30px;\n    width: 17em;\n    border: 1px solid gray;\n    outline:none;\n    font-size: 1em;\n    padding: 5px 55px 5px 10px;\n    font-weight: 300;\n    letter-spacing: 0.05em;\n}\n\n.pz-drop-down-indicator {\n    display: inline-block;\n    position: absolute;\n    top: 0;\n    right: 0;\n    padding: 18px;\n    background: rgba(128, 128, 128, 0.3);\n    border-left: solid 1px gray;\n    cursor: pointer;\n}\n\n.pz-arrow-down {\n    width: 0;\n    height: 0;\n    border-left: 6px solid transparent;\n    border-right: 6px solid transparent;\n    border-top: 6px solid #808080;\n}\n\ninput.pz-suggestion-input {\n    border: none;\n    background: transparent;\n    font-size: 0.95em;\n    font-weight: 300;\n    outline: none;\n    padding: 10px 10px;\n    display: block;\n    width: 100%;\n    box-sizing: border-box;\n    user-select: none;\n    -ms-user-select: none;\n    -moz-user-select: none;\n    -khtml-user-select: none;\n    -webkit-user-select: none;\n    -webkit-touch-callout: none;\n    transition: all .35s;\n    cursor: pointer;\n}\n\n.pz-suggestion-input:hover{\n    background: rgba(255, 165, 0, 0.5);\n}\n\n.pz-suggestion-input:focus{\n    background: lightgreen;\n}\n\n.pz-child-suggestion-box{\n    border-bottom: solid 1px #ababab;\n}\n\n.pz-child-suggestion-box:last-child{\n    border-bottom: none;\n}\n\n.pz-drop-down-children{\n    background: #eaeaea;\n    border: solid 1px #ababab;\n    border-top: none;\n    max-height: 194px;\n    overflow: scroll;\n}\n\n.pz-drop-down-children.pz-hide{\n    display:none;\n}\n\n.pz-drop-down-children.pz-show{\n    display:block;\n}\n\n.pz-suggestion-input:hover{\n    background: rgba(255, 165, 0, 0.5);\n}\n\n.pz-suggestion-input:focus{\n    background: lightgreen;\n}\n\n.pz-suggestion-input.pz-is-selected{\n    background: lightgreen !important;\n    cursor: default;\n}\n\n.pz-child-suggestion-box{\n    border-bottom: solid 1px #ababab;\n}\n\n.pz-child-suggestion-box:last-child{\n    border-bottom: none;\n}\n\n.pz-drop-down-children{\n    background: #eaeaea;\n    border: solid 1px #ababab;\n    border-top: none;\n    max-height: 194px;\n    overflow: scroll;\n    z-index: 1;\n}\n\n.pz-drop-down-children.pz-hide{\n    display:none;\n}\n\n.pz-drop-down-children.pz-show{\n    display:block;\n}\n\n\n\n.pz-child-suggestion-box.pz-null-action-box input.pz-suggestion-input{\n    background: #d0d0d0;\n    cursor: default;\n}\n.pz-child-suggestion-box.pz-null-action-box input.pz-suggestion-input:hover{\n    background: #d0d0d0;\n}\n", ""]);

// exports


/***/ }),

/***/ 9:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(19);


/***/ })

},[[9,1,2]]]);
});
//# sourceMappingURL=main-4ee7b908bbb9cc78ad0d-min.js.map