const widgetCheckboxes = document.getElementsByClassName('mslwidget__checkbox');
const widgetInputs = document.getElementsByClassName('mslwidget__input');

const handleChecked = target => {
	const targetContainer = target.closest('div.mslwidget__settings');
	const targetClasses = [...target.classList];
	const profileName = targetClasses
		.filter(className => className !== 'mslwidget__checkbox')
		.toString();
	for (let i = 0; i < widgetInputs.length; i++) {
		if (
			widgetInputs[i].classList.contains(profileName) &&
			targetContainer.contains(widgetInputs[i])
		) {
			if (target.checked) {
				widgetInputs[i].parentElement.classList.remove(
					'mslwidget__hidden'
				);
			} else {
				widgetInputs[i].parentElement.classList.add(
					'mslwidget__hidden'
				);
			}
		}
	}
};

const initVisibleInputs = () => {
	for (let i = 0; i < widgetInputs.length; i++) {
		const inputClasses = [...widgetInputs[i].classList];
		const profileName = inputClasses
			.filter(className => className !== 'mslwidget__input')
			.toString();
		for (let i = 0; i < widgetCheckboxes.length; i++) {
			if (
				widgetCheckboxes[i].classList.contains(profileName) &&
				!widgetCheckboxes[i].checked
			) {
				widgetInputs[i].parentElement.classList.add(
					'mslwidget__hidden'
				);
			}
		}
	}
};

initVisibleInputs();

for (let i = 0; i < widgetCheckboxes.length; i++) {
	widgetCheckboxes[i].addEventListener('click', event =>
		handleChecked(event.target)
	);
}
