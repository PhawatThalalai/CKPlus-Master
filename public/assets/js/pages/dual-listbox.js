(() => {
    var L = "dual-listbox",
        _ = "dual-listbox__container",
        p = "dual-listbox__available",
        b = "dual-listbox__selected",
        r = "dual-listbox__title",
        o = "dual-listbox__item",
        v = "dual-listbox__buttons",
        E = "dual-listbox__button",
        c = "dual-listbox__search",
        n = "dual-listbox__item--selected",
        h = "up",
        u = "down",
        d = class {
            constructor(t, e = {}) {
                this.setDefaults(),
                    (this.dragged = null),
                    (this.options = []),
                    d.isDomElement(t)
                        ? (this.select = t)
                        : (this.select = document.querySelector(t)),
                    this._initOptions(e),
                    this._initReusableElements(),
                    e.options !== void 0
                        ? (this.options = e.options)
                        : this._splitOptions(this.select.options),
                    this._buildDualListbox(this.select.parentNode),
                    this._addActions(),
                    this.showSortButtons && this._initializeSortButtons(),
                    this.redraw();
            }
            setDefaults() {
                (this.availableTitle = "Available options"),
                    (this.selectedTitle = "Selected options"),
                    (this.availableListCustomText =
                        "Your Custom Available Text : "),
                    (this.selectedListCustomText =
                        "Your Custom Selected Text : ");
                (this.showAddButton = !0),
                    (this.addButtonText = "add"),
                    (this.showRemoveButton = !0),
                    (this.removeButtonText = "remove"),
                    (this.showAddAllButton = !0),
                    (this.addAllButtonText = "add all"),
                    (this.showRemoveAllButton = !0),
                    (this.removeAllButtonText = "remove all"),
                    (this.searchPlaceholder = "Search"),
                    (this.showSortButtons = !1),
                    (this.sortFunction = (t, e) =>
                        t.selected
                            ? -1
                            : e.selected
                            ? 1
                            : t.order < e.order
                            ? -1
                            : t.order > e.order
                            ? 1
                            : 0),
                    (this.upButtonText = "up"),
                    (this.downButtonText = "down"),
                    (this.enableDoubleClick = !0),
                    (this.draggable = !0);
            }
            changeOrder(t, e) {
                console.log(t);
                let s = this.options.findIndex(
                    (a) => (
                        console.log(a, t.dataset.id), a.value === t.dataset.id
                    )
                );
                console.log(s);
                let i = this.options.splice(s, 1);
                console.log(i), this.options.splice(e, 0, i[0]);
            }
            addOptions(t) {
                t.forEach((e) => {
                    this.addOption(e);
                });
            }
            addOption(t, e = null) {
                e ? this.options.splice(e, 0, t) : this.options.push(t);
            }
            addEventListener(t, e) {
                this.dualListbox.addEventListener(t, e);
            }
            changeSelected(t) {
                let e = this.options.find((s) => s.value === t.dataset.id);
                (e.selected = !e.selected),
                    this.redraw(),
                    setTimeout(() => {
                        let s = document.createEvent("HTMLEvents");
                        e.selected
                            ? (s.initEvent("added", !1, !0),
                              (s.addedElement = t))
                            : (s.initEvent("removed", !1, !0),
                              (s.removedElement = t)),
                            this.dualListbox.dispatchEvent(s);
                    }, 0);
            }
            actionAllSelected(t) {
                t && t.preventDefault();

                    // Trigger a custom event (you can replace "customSelectAllEvent" with your desired event name)
                    let selectAllEvent = new Event("SelectAllEvent");
                    this.dualListbox.dispatchEvent(selectAllEvent);

                    // Count the total number of items before selecting all
                    let totalItemsBefore = this.options.length;

                    this.options.forEach((e) => (e.selected = !0));

                    // Count the total number of items after selecting all
                    let totalItemsAfter = this.options.length;

                    // Calculate the number of newly selected items
                    let newlySelectedCount = totalItemsAfter - totalItemsBefore;

                    $('#CountselectedList').html("Count Selected : " + totalItemsBefore + " item");
                    $('#CountavailableList').html("Count Available : " + newlySelectedCount + " item");
                    this.redraw();
            }
            actionAllDeselected(t) {
                t && t.preventDefault();
                    // Count the total number of items before deselecting all
                    let removeAllEvent = new Event("RemoveAllEvent");
                    this.dualListbox.dispatchEvent(removeAllEvent);

                    let totalItemsBefore = this.options.length;

                    this.options.forEach((e) => (e.selected = false));

                    // Count the total number of items after deselecting all
                    let totalItemsAfter = this.options.length;

                    // Calculate the number of newly deselected items
                    let newlyDeselectedCount = totalItemsBefore - totalItemsAfter;

                    $('#CountavailableList').html("Count Available : " + totalItemsBefore + " item");
                    $('#CountselectedList').html("Count Selected : " + newlyDeselectedCount + " item");
                    this.redraw();
            }
            redraw() {
                this.options.sort(this.sortFunction),
                    this.updateAvailableListbox(),
                    this.updateSelectedListbox(),
                    this.syncSelect();
            }
            searchLists(t, e) {
                let s = e.querySelectorAll(`.${o}`),
                    i = t.toLowerCase();
                for (let a = 0; a < s.length; a++) {
                    let l = s[a];
                    l.textContent.toLowerCase().indexOf(i) === -1
                        ? (l.style.display = "none")
                        : (l.style.display = "list-item");
                }
            }
            updateAvailableListbox() {
                this._updateListbox(
                    this.availableList,
                    this.options.filter((t) => !t.selected)
                );
            }
            updateSelectedListbox() {
                this._updateListbox(
                    this.selectedList,
                    this.options.filter((t) => t.selected)
                );
            }
            syncSelect() {
                for (; this.select.firstChild; )
                    this.select.removeChild(this.select.lastChild);
                this.options.forEach((t) => {
                    let e = document.createElement("option");
                    (e.value = t.value),
                        (e.innerText = t.text),
                        t.selected && e.setAttribute("selected", "selected"),
                        this.select.appendChild(e);
                });
            }
            _updateListbox(t, e) {
                for (; t.firstChild; ) t.removeChild(t.firstChild);
                e.forEach((s) => {
                    t.appendChild(this._createListItem(s));
                });

                // เพิ่ม console.log เพื่อตรวจสอบว่ามีรายการถูกส่งมาหรือไม่
                // console.log("Number of items:", e.length);
            }
            actionItemSelected(t) {
                t.preventDefault();
                let e = this.availableList.querySelector(`.${n}`);
                e && this.changeSelected(e);
            }
            actionItemDeselected(t) {
                t.preventDefault();
                let e = this.selectedList.querySelector(`.${n}`);
                e && this.changeSelected(e);
            }
            _actionItemDoubleClick(t, e = null) {
                e && (e.preventDefault(), e.stopPropagation()),
                    this.enableDoubleClick && this.changeSelected(t);
            }
            _actionItemClick(t, e, s = null) {
                s && s.preventDefault();
                let i = e.querySelectorAll(`.${o}`);
                for (let a = 0; a < i.length; a++) {
                    let l = i[a];
                    l !== t && l.classList.remove(n);
                }
                t.classList.contains(n)
                    ? t.classList.remove(n)
                    : t.classList.add(n);
            }
            _addActions() {
                this._addButtonActions(), this._addSearchActions();
            }
            _addButtonActions() {
                this.add_all_button.addEventListener("click", (t) =>
                    this.actionAllSelected(t)
                ),
                    this.add_button.addEventListener("click", (t) =>
                        this.actionItemSelected(t)
                    ),
                    this.remove_button.addEventListener("click", (t) =>
                        this.actionItemDeselected(t)
                    ),
                    this.remove_all_button.addEventListener("click", (t) =>
                        this.actionAllDeselected(t)
                    );
            }
            _addClickActions(t) {
                return (
                    t.addEventListener("dblclick", (e) =>
                        this._actionItemDoubleClick(t, e)
                    ),
                    t.addEventListener("click", (e) =>
                        this._actionItemClick(t, this.dualListbox, e)
                    ),
                    t
                );
            }
            _addSearchActions() {
                this.search_left.addEventListener("change", (t) =>
                    this.searchLists(t.target.value, this.availableList)
                ),
                    this.search_left.addEventListener("keyup", (t) =>
                        this.searchLists(t.target.value, this.availableList)
                    ),
                    this.search_right.addEventListener("change", (t) =>
                        this.searchLists(t.target.value, this.selectedList)
                    ),
                    this.search_right.addEventListener("keyup", (t) =>
                        this.searchLists(t.target.value, this.selectedList)
                    );
            }
            _buildDualListbox(t) {
                (this.select.style.display = "none"),
                    this.dualListBoxContainer.appendChild(
                        this._createList(
                            this.search_left,
                            this.availableListTitle,
                            this.availableList,
                            this.availableListCustomText, // นำตัวแปรใหม่มาใช้ที่นี่
                            "CountavailableList",
                        )
                    ),
                    this.dualListBoxContainer.appendChild(this.buttons),
                    this.dualListBoxContainer.appendChild(
                        this._createList(
                            this.search_right,
                            this.selectedListTitle,
                            this.selectedList,
                            this.selectedListCustomText, // นำตัวแปรใหม่มาใช้ที่นี่
                            "CountselectedList",
                        )
                    ),
                    this.dualListbox.appendChild(this.dualListBoxContainer),
                    t.insertBefore(this.dualListbox, this.select);
            }
            _createList(t, e, s, customText, id) {
                // let i = document.createElement("div");
                // return i.appendChild(t), i.appendChild(e), i.appendChild(s), i;
                let i = document.createElement("div");
                i.appendChild(t);
                i.appendChild(e);
                i.appendChild(s);

                // เพิ่มข้อความในที่ท้ายรายการ
                if (customText && id) {
                    let customTextElement = document.createElement("div");
                    customTextElement.innerText = customText;
                    customTextElement.id = id;  // Append to the id

                    let itemCountElement = document.createElement("span");
                    // itemCountElement.innerText = ``;    //count

                    customTextElement.appendChild(itemCountElement);
                    i.appendChild(customTextElement);
                }

                return i;
            }
            _createButtons() {
                (this.buttons = document.createElement("div")),
                    this.buttons.classList.add(v),
                    (this.add_all_button = document.createElement("button")),
                    (this.add_all_button.innerHTML = this.addAllButtonText),
                    (this.add_button = document.createElement("button")),
                    (this.add_button.innerHTML = this.addButtonText),
                    (this.remove_button = document.createElement("button")),
                    (this.remove_button.innerHTML = this.removeButtonText),
                    (this.remove_all_button = document.createElement("button")),
                    (this.remove_all_button.innerHTML =
                        this.removeAllButtonText);
                let t = {
                    showAddAllButton: this.add_all_button,
                    showAddButton: this.add_button,
                    showRemoveButton: this.remove_button,
                    showRemoveAllButton: this.remove_all_button,
                };
                for (let e in t)
                    if (e) {
                        let s = this[e],
                            i = t[e];
                        i.setAttribute("type", "button"),
                            i.classList.add(E),
                            s && this.buttons.appendChild(i);
                    }
            }
            _createListItem(t) {
                let e = document.createElement("li");
                return (
                    e.classList.add(o),
                    (e.innerHTML = t.text),
                    (e.dataset.id = t.value),
                    this._liListeners(e),
                    this._addClickActions(e),
                    this.draggable && e.setAttribute("draggable", "true"),
                    e
                );
            }
            _liListeners(t) {
                t.addEventListener("dragstart", (e) => {
                    console.log("drag start", e),
                        (this.dragged = e.currentTarget),
                        e.currentTarget.classList.add("dragging");
                }),
                    t.addEventListener("dragend", (e) => {
                        e.currentTarget.classList.remove("dragging");
                    }),
                    t.addEventListener(
                        "dragover",
                        (e) => {
                            e.preventDefault();
                        },
                        !1
                    ),
                    t.addEventListener("dragenter", (e) => {
                        e.target.classList.add("drop-above");
                    }),
                    t.addEventListener("dragleave", (e) => {
                        e.target.classList.remove("drop-above");
                    }),
                    t.addEventListener("drop", (e) => {
                        e.preventDefault(),
                            e.stopPropagation(),
                            e.target.classList.remove("drop-above");
                        let s = this.options.findIndex(
                            (i) => i.value === e.target.dataset.id
                        );
                        e.target.parentElement === this.dragged.parentElement
                            ? (this.changeOrder(this.dragged, s), this.redraw())
                            : (this.changeSelected(this.dragged),
                              this.changeOrder(this.dragged, s),
                              this.redraw());
                    });
            }
            _createSearchLeft() {
                (this.search_left = document.createElement("input")),
                    this.search_left.classList.add(c),
                    (this.search_left.placeholder = this.searchPlaceholder);
            }
            _createSearchRight() {
                (this.search_right = document.createElement("input")),
                    this.search_right.classList.add(c),
                    (this.search_right.placeholder = this.searchPlaceholder);
            }
            _createDragListeners() {
                [this.availableList, this.selectedList].forEach((t) => {
                    t.addEventListener(
                        "dragover",
                        (e) => {
                            e.preventDefault();
                        },
                        !1
                    ),
                        t.addEventListener("dragenter", (e) => {
                            e.target.classList.add("drop-in");
                        }),
                        t.addEventListener("dragleave", (e) => {
                            e.target.classList.remove("drop-in");
                        }),
                        t.addEventListener("drop", (e) => {
                            e.preventDefault(),
                                e.target.classList.remove("drop-in"),
                                (t.classList.contains(
                                    "dual-listbox__selected"
                                ) ||
                                    t.classList.contains(
                                        "dual-listbox__available"
                                    )) &&
                                    this.changeSelected(this.dragged);
                        });
                });
            }
            _initOptions(t) {
                for (let e in t) t.hasOwnProperty(e) && (this[e] = t[e]);
            }
            _initReusableElements() {
                (this.dualListbox = document.createElement("div")),
                    this.dualListbox.classList.add(L),
                    this.select.id &&
                        this.dualListbox.classList.add(this.select.id),
                    (this.dualListBoxContainer = document.createElement("div")),
                    this.dualListBoxContainer.classList.add(_),
                    (this.availableList = document.createElement("ul")),
                    this.availableList.classList.add(p),
                    (this.selectedList = document.createElement("ul")),
                    this.selectedList.classList.add(b),
                    (this.availableListTitle = document.createElement("div")),
                    this.availableListTitle.classList.add(r),
                    (this.availableListTitle.innerText = this.availableTitle),
                    (this.selectedListTitle = document.createElement("div")),
                    this.selectedListTitle.classList.add(r),
                    (this.selectedListTitle.innerText = this.selectedTitle),
                    this._createButtons(),
                    this._createSearchLeft(),
                    this._createSearchRight(),
                    this.draggable &&
                        setTimeout(() => {
                            this._createDragListeners();
                        }, 10);
            }
            _splitOptions(t) {
                [...t].forEach((e, s) => {
                    this.addOption({
                        text: e.innerHTML,
                        value: e.value,
                        selected: e.attributes.selected || !1,
                        order: s,
                    });
                });
            }
            _initializeSortButtons() {
                let t = document.createElement("button");
                t.classList.add("dual-listbox__button"),
                    (t.innerText = this.upButtonText),
                    t.addEventListener("click", (i) =>
                        this._onSortButtonClick(i, h)
                    );
                let e = document.createElement("button");
                e.classList.add("dual-listbox__button"),
                    (e.innerText = this.downButtonText),
                    e.addEventListener("click", (i) =>
                        this._onSortButtonClick(i, u)
                    );
                let s = document.createElement("div");
                s.classList.add("dual-listbox__buttons"),
                    s.appendChild(t),
                    s.appendChild(e),
                    this.dualListBoxContainer.appendChild(s);
            }
            _onSortButtonClick(t, e) {
                t.preventDefault();
                let s = this.dualListbox.querySelector(
                        ".dual-listbox__item--selected"
                    ),
                    i = this.options.find((a) => a.value === s.dataset.id);
                if (s) {
                    let a = this._getNewIndex(s, e);
                    a >= 0 && (this.changeOrder(s, a), this.redraw());
                }
            }
            _getNewIndex(t, e) {
                let s = this.options.findIndex((a) => a.value === t.dataset.id),
                    i = s;
                return (
                    h === e
                        ? (i -= 1)
                        : u === e && s < t.length - 1 && (i += 1),
                    i
                );
            }
            static isDomElement(t) {
                return typeof HTMLElement == "object"
                    ? t instanceof HTMLElement
                    : t &&
                          typeof t == "object" &&
                          t !== null &&
                          t.nodeType === 1 &&
                          typeof t.nodeName == "string";
            }
        };
    window.DualListbox = d;
    var m = d;
})();
//# sourceMappingURL=dual-listbox.js.map
