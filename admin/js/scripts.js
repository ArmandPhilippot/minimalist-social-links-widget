"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var widgetCheckboxes = document.getElementsByClassName('mslwidget__checkbox');
var widgetInputs = document.getElementsByClassName('mslwidget__input');

var handleChecked = function handleChecked(target) {
  var targetContainer = target.closest('div.mslwidget__settings');

  var targetClasses = _toConsumableArray(target.classList);

  var profileName = targetClasses.filter(function (className) {
    return className !== 'mslwidget__checkbox';
  }).toString();

  for (var i = 0; i < widgetInputs.length; i++) {
    if (widgetInputs[i].classList.contains(profileName) && targetContainer.contains(widgetInputs[i])) {
      if (target.checked) {
        widgetInputs[i].parentElement.classList.remove('mslwidget__hidden');
      } else {
        widgetInputs[i].parentElement.classList.add('mslwidget__hidden');
      }
    }
  }
};

var initVisibleInputs = function initVisibleInputs() {
  for (var i = 0; i < widgetInputs.length; i++) {
    var inputClasses = _toConsumableArray(widgetInputs[i].classList);

    var profileName = inputClasses.filter(function (className) {
      return className !== 'mslwidget__input';
    }).toString();

    for (var _i = 0; _i < widgetCheckboxes.length; _i++) {
      if (widgetCheckboxes[_i].classList.contains(profileName) && !widgetCheckboxes[_i].checked) {
        widgetInputs[_i].parentElement.classList.add('mslwidget__hidden');
      }
    }
  }
};

initVisibleInputs();

for (var i = 0; i < widgetCheckboxes.length; i++) {
  widgetCheckboxes[i].addEventListener('click', function (event) {
    return handleChecked(event.target);
  });
}