/**
 * Add or remove a class to hide an element.
 * @param {HTMLElement} fieldset An HTML element.
 * @param {HTMLCollection} checkboxes A collection of checkbox element.
 */
const setFieldsetVisibility = (fieldset, checkboxes) => {
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
const changeInputVisibility = (inputParent, visibility) => {
	if ('hide' === visibility) {
		inputParent.classList.replace(
			'mslwidget__item--grid',
			'mslwidget__hidden'
		);
	} else if ('show' === visibility) {
		inputParent.classList.replace(
			'mslwidget__hidden',
			'mslwidget__item--grid'
		);
	}
};

/**
 * Verify if at least one checkbox is checked.
 * @param {HTMLCollection} checkboxList A collection of checkbox elements.
 * @returns True if one of them is checked.
 */
const atLeastOneIsChecked = checkboxList => {
	const isChecked = Array.prototype.slice
		.call(checkboxList)
		.some(checkbox => checkbox.checked);
	return isChecked;
};

/**
 * Filter a list of classes to obtain the website profile name.
 * @param {Array} classes A list of class names.
 * @returns {String} The website profile name.
 */
const getProfileNameFrom = classes => {
	const profileName = classes
		.filter(
			className =>
				className !== 'mslwidget__checkbox' &&
				className !== 'mslwidget__input'
		)
		.toString();
	return profileName;
};

/**
 * Define visibility of fieldset and inputs compared to checked checkboxes.
 * @param {HTMLElement} target A targeted HTML element.
 * @param {HTMLElement} inputFieldset A fieldset containing target.
 * @param {HTMLCollection} checkboxes A collection of checkbox inside fieldset.
 */
const handleChecked = (target, inputFieldset, checkboxes) => {
	const targetContainer = target.closest('div.mslwidget__settings');
	const targetClasses = [...target.classList];
	const profileName = getProfileNameFrom(targetClasses);
	const inputs = targetContainer.getElementsByClassName('mslwidget__input');

	for (let i = 0; i < inputs.length; i++) {
		const inputParent = inputs[i].parentElement;
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
const initVisibleInputs = (inputs, checkboxes) => {
	for (let i = 0; i < inputs.length; i++) {
		const input = inputs[i];
		const inputClasses = [...input.classList];
		const profileName = getProfileNameFrom(inputClasses);

		for (let j = 0; j < checkboxes.length; j++) {
			const checkbox = checkboxes[j];
			const checkboxClasses = checkbox.classList;
			if (checkboxClasses.contains(profileName) && !checkbox.checked) {
				changeInputVisibility(input.parentElement, 'hide');
			}
		}
	}
};

/**
 * Define initial state of MSL widget settings.
 */
const initWidgetSettings = () => {
	const widgetSettings = document.getElementsByClassName(
		'mslwidget__settings'
	);

	for (let i = 0; i < widgetSettings.length; i++) {
		const checkboxes = widgetSettings[i].getElementsByClassName(
			'mslwidget__checkbox'
		);
		const inputs = widgetSettings[i].getElementsByClassName(
			'mslwidget__input'
		);
		const inputFieldset = widgetSettings[i].getElementsByClassName(
			'mslwidget__fieldset--inputs'
		);

		initVisibleInputs(inputs, checkboxes);

		for (let j = 0; j < inputFieldset.length; j++) {
			setFieldsetVisibility(inputFieldset[j], checkboxes);
			for (let k = 0; k < checkboxes.length; k++) {
				checkboxes[k].addEventListener('click', event =>
					handleChecked(event.target, inputFieldset[j], checkboxes)
				);
			}
		}
	}
};

const wpBody = document.getElementById('wpbody-content');
const observer = new MutationObserver(initWidgetSettings);

observer.observe(wpBody, { childList: true, subtree: true });
