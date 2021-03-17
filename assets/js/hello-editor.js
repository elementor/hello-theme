/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \*****************************************************************/
/***/ ((module) => {

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

module.exports = _arrayLikeToArray;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithHoles.js ***!
  \***************************************************************/
/***/ ((module) => {

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

module.exports = _arrayWithHoles;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/assertThisInitialized.js ***!
  \**********************************************************************/
/***/ ((module) => {

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

module.exports = _assertThisInitialized;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/classCallCheck.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/classCallCheck.js ***!
  \***************************************************************/
/***/ ((module) => {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

module.exports = _classCallCheck;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/createClass.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/createClass.js ***!
  \************************************************************/
/***/ ((module) => {

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

module.exports = _createClass;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/createSuper.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/createSuper.js ***!
  \************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var getPrototypeOf = __webpack_require__(/*! ./getPrototypeOf.js */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");

var isNativeReflectConstruct = __webpack_require__(/*! ./isNativeReflectConstruct.js */ "./node_modules/@babel/runtime/helpers/isNativeReflectConstruct.js");

var possibleConstructorReturn = __webpack_require__(/*! ./possibleConstructorReturn.js */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");

function _createSuper(Derived) {
  var hasNativeReflectConstruct = isNativeReflectConstruct();
  return function _createSuperInternal() {
    var Super = getPrototypeOf(Derived),
        result;

    if (hasNativeReflectConstruct) {
      var NewTarget = getPrototypeOf(this).constructor;
      result = Reflect.construct(Super, arguments, NewTarget);
    } else {
      result = Super.apply(this, arguments);
    }

    return possibleConstructorReturn(this, result);
  };
}

module.exports = _createSuper;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/defineProperty.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \***************************************************************/
/***/ ((module) => {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/getPrototypeOf.js ***!
  \***************************************************************/
/***/ ((module) => {

function _getPrototypeOf(o) {
  module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  module.exports.default = module.exports, module.exports.__esModule = true;
  return _getPrototypeOf(o);
}

module.exports = _getPrototypeOf;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/inherits.js":
/*!*********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/inherits.js ***!
  \*********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var setPrototypeOf = __webpack_require__(/*! ./setPrototypeOf.js */ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js");

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) setPrototypeOf(subClass, superClass);
}

module.exports = _inherits;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/interopRequireDefault.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/interopRequireDefault.js ***!
  \**********************************************************************/
/***/ ((module) => {

function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {
    "default": obj
  };
}

module.exports = _interopRequireDefault;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/isNativeReflectConstruct.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/isNativeReflectConstruct.js ***!
  \*************************************************************************/
/***/ ((module) => {

function _isNativeReflectConstruct() {
  if (typeof Reflect === "undefined" || !Reflect.construct) return false;
  if (Reflect.construct.sham) return false;
  if (typeof Proxy === "function") return true;

  try {
    Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
    return true;
  } catch (e) {
    return false;
  }
}

module.exports = _isNativeReflectConstruct;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js ***!
  \*********************************************************************/
/***/ ((module) => {

function _iterableToArrayLimit(arr, i) {
  if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
  var _arr = [];
  var _n = true;
  var _d = false;
  var _e = undefined;

  try {
    for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

module.exports = _iterableToArrayLimit;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/nonIterableRest.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableRest.js ***!
  \****************************************************************/
/***/ ((module) => {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableRest;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js ***!
  \**************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var _typeof = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "./node_modules/@babel/runtime/helpers/typeof.js").default;

var assertThisInitialized = __webpack_require__(/*! ./assertThisInitialized.js */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return assertThisInitialized(self);
}

module.exports = _possibleConstructorReturn;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/setPrototypeOf.js ***!
  \***************************************************************/
/***/ ((module) => {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  module.exports.default = module.exports, module.exports.__esModule = true;
  return _setPrototypeOf(o, p);
}

module.exports = _setPrototypeOf;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/slicedToArray.js":
/*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/slicedToArray.js ***!
  \**************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var arrayWithHoles = __webpack_require__(/*! ./arrayWithHoles.js */ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js");

var iterableToArrayLimit = __webpack_require__(/*! ./iterableToArrayLimit.js */ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js");

var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");

var nonIterableRest = __webpack_require__(/*! ./nonIterableRest.js */ "./node_modules/@babel/runtime/helpers/nonIterableRest.js");

function _slicedToArray(arr, i) {
  return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || unsupportedIterableToArray(arr, i) || nonIterableRest();
}

module.exports = _slicedToArray;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/typeof.js":
/*!*******************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/typeof.js ***!
  \*******************************************************/
/***/ ((module) => {

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };

    module.exports.default = module.exports, module.exports.__esModule = true;
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };

    module.exports.default = module.exports, module.exports.__esModule = true;
  }

  return _typeof(obj);
}

module.exports = _typeof;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \***************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}

module.exports = _unsupportedIterableToArray;
module.exports.default = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "./assets/dev/js/editor/component.js":
/*!*******************************************!*\
  !*** ./assets/dev/js/editor/component.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "./node_modules/@babel/runtime/helpers/interopRequireDefault.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports.default = void 0;

var _classCallCheck2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js"));

var _createClass2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js"));

var _assertThisInitialized2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/assertThisInitialized */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js"));

var _inherits2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js"));

var _createSuper2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/createSuper */ "./node_modules/@babel/runtime/helpers/createSuper.js"));

var _defineProperty2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js"));

var _controlsHook = _interopRequireDefault(__webpack_require__(/*! ./hooks/ui/controls-hook */ "./assets/dev/js/editor/hooks/ui/controls-hook.js"));

var _default = /*#__PURE__*/function (_$e$modules$Component) {
  (0, _inherits2["default"])(_default, _$e$modules$Component);

  var _super = (0, _createSuper2["default"])(_default);

  function _default() {
    var _this;

    (0, _classCallCheck2["default"])(this, _default);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));
    (0, _defineProperty2["default"])((0, _assertThisInitialized2["default"])(_this), "pages", {});
    return _this;
  }

  (0, _createClass2["default"])(_default, [{
    key: "getNamespace",
    value: function getNamespace() {
      return 'hello-elementor';
    }
  }, {
    key: "defaultHooks",
    value: function defaultHooks() {
      return this.importHooks({
        ControlsHook: _controlsHook["default"]
      });
    }
  }]);
  return _default;
}($e.modules.ComponentBase);

exports.default = _default;

/***/ }),

/***/ "./assets/dev/js/editor/hooks/ui/controls-hook.js":
/*!********************************************************!*\
  !*** ./assets/dev/js/editor/hooks/ui/controls-hook.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "./node_modules/@babel/runtime/helpers/interopRequireDefault.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports.default = void 0;

var _slicedToArray2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/slicedToArray.js"));

var _classCallCheck2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js"));

var _createClass2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js"));

var _inherits2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js"));

var _createSuper2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/createSuper */ "./node_modules/@babel/runtime/helpers/createSuper.js"));

var ControlsHook = /*#__PURE__*/function (_$e$modules$hookUI$Af) {
  (0, _inherits2["default"])(ControlsHook, _$e$modules$hookUI$Af);

  var _super = (0, _createSuper2["default"])(ControlsHook);

  function ControlsHook() {
    (0, _classCallCheck2["default"])(this, ControlsHook);
    return _super.apply(this, arguments);
  }

  (0, _createClass2["default"])(ControlsHook, [{
    key: "getCommand",
    value: function getCommand() {
      // Command to listen.
      return 'document/elements/settings';
    }
  }, {
    key: "getId",
    value: function getId() {
      // Unique id for the hook.
      return 'hello-elementor-editor-controls-handler';
    }
    /**
     * Get Hello Theme Controls
     *
     * Returns an object in which the keys are control IDs, and the values are the selectors of the elements that need
     * to be targeted in the apply() method.
     *
     * Example return value:
     *   {
     *      hello_elementor_show_logo: '.site-header .site-header-logo',
     *      hello_elementor_show_menu: '.site-header .site-header-menu',
     *   }
     */

  }, {
    key: "getHelloThemeControls",
    value: function getHelloThemeControls() {
      var _this = this;

      return {
        hello_header_logo_display: {
          selector: '.site-header .site-logo, .site-header .site-title',
          callback: function callback($element, args) {
            _this.toggleShowHideClass($element, args.settings.hello_header_logo_display);
          }
        },
        hello_header_menu_display: {
          selector: '.site-header .site-navigation, .site-header .site-navigation-toggle-holder',
          callback: function callback($element, args) {
            _this.toggleShowHideClass($element, args.settings.hello_header_menu_display);
          }
        },
        hello_header_tagline_display: {
          selector: '.site-header .site-description',
          callback: function callback($element, args) {
            _this.toggleShowHideClass($element, args.settings.hello_header_tagline_display);
          }
        },
        hello_header_logo_type: {
          selector: '.site-header .site-branding',
          callback: function callback($element, args) {
            var classPrefix = 'show-',
                inputOptions = args.container.controls.hello_header_logo_type.options,
                inputValue = args.settings.hello_header_logo_type;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        },
        hello_header_layout: {
          selector: '.site-header',
          callback: function callback($element, args) {
            var classPrefix = 'header-',
                inputOptions = args.container.controls.hello_header_layout.options,
                inputValue = args.settings.hello_header_layout;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        },
        hello_header_width: {
          selector: '.site-header',
          callback: function callback($element, args) {
            var classPrefix = 'header-',
                inputOptions = args.container.controls.hello_header_width.options,
                inputValue = args.settings.hello_header_width;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        },
        hello_header_menu_layout: {
          selector: '.site-header',
          callback: function callback($element, args) {
            var classPrefix = 'menu-layout-',
                inputOptions = args.container.controls.hello_header_menu_layout.options,
                inputValue = args.settings.hello_header_menu_layout;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        },
        hello_header_menu_dropdown: {
          selector: '.site-header',
          callback: function callback($element, args) {
            var classPrefix = 'menu-dropdown-',
                inputOptions = args.container.controls.hello_header_menu_dropdown.options,
                inputValue = args.settings.hello_header_menu_dropdown;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        },
        hello_footer_logo_display: {
          selector: '.site-footer .site-logo, .site-footer .site-title',
          callback: function callback($element, args) {
            _this.toggleShowHideClass($element, args.settings.hello_footer_logo_display);
          }
        },
        hello_footer_tagline_display: {
          selector: '.site-footer .site-description',
          callback: function callback($element, args) {
            _this.toggleShowHideClass($element, args.settings.hello_footer_tagline_display);
          }
        },
        hello_footer_menu_display: {
          selector: '.site-footer .site-navigation',
          callback: function callback($element, args) {
            _this.toggleShowHideClass($element, args.settings.hello_footer_menu_display);
          }
        },
        hello_footer_copyright_display: {
          selector: '.site-footer .copyright',
          callback: function callback($element, args) {
            _this.toggleShowHideClass($element, args.settings.hello_footer_copyright_display);
          }
        },
        hello_footer_logo_type: {
          selector: '.site-footer .site-branding',
          callback: function callback($element, args) {
            var classPrefix = 'show-',
                inputOptions = args.container.controls.hello_footer_logo_type.options,
                inputValue = args.settings.hello_footer_logo_type;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        },
        hello_footer_layout: {
          selector: '.site-footer',
          callback: function callback($element, args) {
            var classPrefix = 'footer-',
                inputOptions = args.container.controls.hello_footer_layout.options,
                inputValue = args.settings.hello_footer_layout;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        },
        hello_footer_width: {
          selector: '.site-footer',
          callback: function callback($element, args) {
            var classPrefix = 'footer-',
                inputOptions = args.container.controls.hello_footer_width.options,
                inputValue = args.settings.hello_footer_width;

            _this.toggleLayoutClass($element, classPrefix, inputOptions, inputValue);
          }
        }
      };
    }
    /**
     * Toggle show and hide classes on containers
     *
     * This will remove the .show and .hide clases from the element, then apply the new class
     *
     */

  }, {
    key: "toggleShowHideClass",
    value: function toggleShowHideClass(element, inputValue) {
      element.removeClass('hide').removeClass('show').addClass(inputValue ? 'show' : 'hide');
    }
    /**
     * Toggle layout classes on containers
     *
     * This will cleanly set classes onto which ever container we want to target, removing the old classes and adding the new one
     *
     */

  }, {
    key: "toggleLayoutClass",
    value: function toggleLayoutClass(element, classPrefix, inputOptions, inputValue) {
      // Loop through the possible classes and remove the one that's not in use
      Object.entries(inputOptions).forEach(function (_ref) {
        var _ref2 = (0, _slicedToArray2["default"])(_ref, 2),
            key = _ref2[0],
            value = _ref2[1];

        element.removeClass(classPrefix + key);
      }); // Append the class which we want to use onto the element

      if ('' !== inputValue) {
        element.addClass(classPrefix + inputValue);
      }
    }
    /**
     * Set the conditions under which the hook will run.
     */

  }, {
    key: "getConditions",
    value: function getConditions(args) {
      var isKit = 'kit' === elementor.documents.getCurrent().config.type,
          changedControls = Object.keys(args.settings),
          isSingleSetting = 1 === changedControls.length; // If the document is not a kit, or there are no changed settings, or there is more than one single changed
      // setting, don't run the hook.

      if (!isKit || !args.settings || !isSingleSetting) {
        return false;
      } // If the changed control is in the list of theme controls, return true to run the hook.
      // Otherwise, return false so the hook doesn't run.


      return !!Object.keys(this.getHelloThemeControls()).includes(changedControls[0]);
    }
    /**
     * The hook logic.
     */

  }, {
    key: "apply",
    value: function apply(args, result) {
      var allThemeControls = this.getHelloThemeControls(),
          // Extract the control ID from the passed args
      controlId = Object.keys(args.settings)[0],
          controlConfig = allThemeControls[controlId],
          // Find the element that needs to be targeted by the control.
      $element = elementor.$previewContents.find(controlConfig.selector);
      controlConfig.callback($element, args);
    }
  }]);
  return ControlsHook;
}($e.modules.hookUI.After);

exports.default = ControlsHook;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!**********************************************!*\
  !*** ./assets/dev/js/editor/hello-editor.js ***!
  \**********************************************/


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "./node_modules/@babel/runtime/helpers/interopRequireDefault.js");

var _component = _interopRequireDefault(__webpack_require__(/*! ./component */ "./assets/dev/js/editor/component.js"));

$e.components.register(new _component["default"]());
})();

/******/ })()
;
//# sourceMappingURL=hello-editor.js.map