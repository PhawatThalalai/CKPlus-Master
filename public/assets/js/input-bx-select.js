
function inputBX_checkSelectValue(selectElement) {
    var spanElement = selectElement;
    
    if (selectElement.value !== "") {
        spanElement.classList.add("has-value");
    } else {
        spanElement.classList.remove("has-value");
    }
}

$(".input-bx select").on("change", function() {
    inputBX_checkSelectValue(this);
});