"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/**
 * Add or remove a class to hide an element.
 * @param {HTMLElement} fieldset An HTML element.
 * @param {HTMLCollection} checkboxes A collection of checkbox element.
 */
var setFieldsetVisibility = function setFieldsetVisibility(fieldset, checkboxes) {
  if (atLeastOneIsChecked(checkboxes)) {
    fieldset.classList.remove('mslwidget__hidden');
  } else {
    fieldset.classList.add('mslwidget__hidden');
  }
};
/**
 * Replace a class with another to handle visibility.
 * @param {HTMLElement} inputParent The parent input.
 * @param {String} visibility Either `hide` or `show`.
 */


var changeInputVisibility = function changeInputVisibility(inputParent, visibility) {
  if ('hide' === visibility) {
    inputParent.classList.replace('mslwidget__item--grid', 'mslwidget__hidden');
  } else if ('show' === visibility) {
    inputParent.classList.replace('mslwidget__hidden', 'mslwidget__item--grid');
  }
};
/**
 * Verify if at least one checkbox is checked.
 * @param {HTMLCollection} checkboxList A collection of checkbox elements.
 * @returns True if one of them is checked.
 */


var atLeastOneIsChecked = function atLeastOneIsChecked(checkboxList) {
  var isChecked = Array.prototype.slice.call(checkboxList).some(function (checkbox) {
    return checkbox.checked;
  });
  return isChecked;
};
/**
 * Filter a list of classes to obtain the website profile name.
 * @param {Array} classes A list of class names.
 * @returns {String} The website profile name.
 */


var getProfileNameFrom = function getProfileNameFrom(classes) {
  var profileName = classes.filter(function (className) {
    return className !== 'mslwidget__checkbox' && className !== 'mslwidget__input';
  }).toString();
  return profileName;
};
/**
 * Define visibility of fieldset and inputs compared to checked checkboxes.
 * @param {HTMLElement} target A targeted HTML element.
 * @param {HTMLElement} inputFieldset A fieldset containing target.
 * @param {HTMLCollection} checkboxes A collection of checkbox inside fieldset.
 */


var handleChecked = function handleChecked(target, inputFieldset, checkboxes) {
  var targetContainer = target.closest('div.mslwidget__settings');

  var targetClasses = _toConsumableArray(target.classList);

  var profileName = getProfileNameFrom(targetClasses);
  var inputs = targetContainer.getElementsByClassName('mslwidget__input');

  for (var i = 0; i < inputs.length; i++) {
    var inputParent = inputs[i].parentElement;

    if (inputs[i].classList.contains(profileName)) {
      if (target.checked) {
        changeInputVisibility(inputParent, 'show');
      } else {
        changeInputVisibility(inputParent, 'hide');
      }

      console.log(inputParent);
    }
  }

  setFieldsetVisibility(inputFieldset, checkboxes);
};
/**
 * Define initial visibility of inputs compared to checked checkboxes.
 * @param {HTMLCollection} inputs A collection of input element.
 * @param {HTMLCollection} checkboxes A collection of checkbox element.
 */


var initVisibleInputs = function initVisibleInputs(inputs, checkboxes) {
  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];

    var inputClasses = _toConsumableArray(input.classList);

    var profileName = getProfileNameFrom(inputClasses);

    for (var j = 0; j < checkboxes.length; j++) {
      var checkbox = checkboxes[j];
      var checkboxClasses = checkbox.classList;

      if (checkboxClasses.contains(profileName) && !checkbox.checked) {
        changeInputVisibility(input.parentElement, 'hide');
      }
    }
  }
};
/**
 * Define initial state of MSL widget settings.
 */


var initWidgetSettings = function initWidgetSettings() {
  var widgetSettings = document.getElementsByClassName('mslwidget__settings');

  var _loop = function _loop(i) {
    var checkboxes = widgetSettings[i].getElementsByClassName('mslwidget__checkbox');
    var inputs = widgetSettings[i].getElementsByClassName('mslwidget__input');
    var inputFieldset = widgetSettings[i].getElementsByClassName('mslwidget__fieldset--inputs');
    initVisibleInputs(inputs, checkboxes);

    var _loop2 = function _loop2(j) {
      setFieldsetVisibility(inputFieldset[j], checkboxes);

      for (var k = 0; k < checkboxes.length; k++) {
        checkboxes[k].addEventListener('click', function (event) {
          return handleChecked(event.target, inputFieldset[j], checkboxes);
        });
      }
    };

    for (var j = 0; j < inputFieldset.length; j++) {
      _loop2(j);
    }
  };

  for (var i = 0; i < widgetSettings.length; i++) {
    _loop(i);
  }
};

var wpBody = document.getElementById('wpbody-content');
var observer = new MutationObserver(initWidgetSettings);
observer.observe(wpBody, {
  childList: true,
  subtree: true
});