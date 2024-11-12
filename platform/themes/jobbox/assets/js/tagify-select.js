'use strict';

const tagifySelect = () => {
    const element = document.querySelectorAll('.list-tagify');

    [...element].forEach(inputElm => {
        let dataList = JSON.parse(inputElm.dataset.list)
        let whiteList = []

        for (const data of dataList) {
            whiteList.push({value: data.id, name: data.name});
        }
        let list = String(inputElm.value).split(',')
        let arrayChosen = whiteList.filter((obj) => {
            if (list.includes(String(obj.value))) {
                return {value: obj.id, name: obj.name}
            }
        })

        function tagTemplate(tagData) {
            return `
            <tag title="${(tagData.title || tagData.name)}"
                    contenteditable='false'
                    spellcheck='false'
                    tabIndex="-1"
                    class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ''}"
                    ${this.getAttributes(tagData)}>
                <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                <div class="d-flex align-items-center">
                    <span class='tagify__tag-text'>${tagData.name}</span>
                </div>
            </tag>
        `
        }

        function suggestionItemTemplate(tagData) {
            return `
            <div ${this.getAttributes(tagData)}
                class="tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ''}"
                tabindex="0"
                role="option">

                <div class="d-flex flex-column">
                    <strong>${tagData.name}</strong>
                </div>
            </div>
        `
        }

        // initialize Tagify on the above input node reference
        let tagify = new Tagify(inputElm, {
            tagTextProp: 'name', // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
            enforceWhitelist: true,
            skipInvalid: true, // do not temporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: 'users-list',
                searchKeys: ['id', 'name']  // very important to set by which keys to search for suggestions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
            whitelist: whiteList,
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
        })

        tagify.loadOriginalValues(arrayChosen)
    })
};

$(document).ready(function () {
    tagifySelect();
});
