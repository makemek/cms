function move(fromOpt, toOpt) {
    var options = fromOpt.getSelected();

    for(var item = 0; item < options.length; ++item) {
        if(options[item].selected) {
            toOpt.element.add(options[item]); // move node from src to dest
        }
    }
}

// ---------------- Class ------------------- //
function DropDownMenu(id) {
    this.element = document.getElementById(id);
}

DropDownMenu.prototype.sort = function() {
    $("#" + this.element.id).html(
        $("#" + this.element.id + " option").sort(function (a, b) {
            return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
        }));
};

DropDownMenu.prototype.getSelected = function() {
    var selected = [];
    for(var item = 0; item < this.element.options.length; ++item)
        if(this.element.options[item].selected)
            selected.push(this.element.options[item]);

    return selected;
};

DropDownMenu.prototype.deselectAll = function() {
    for(var item = 0; item < this.element.options.length; ++item)
        this.element.options[item].selected = false;
};
// ------------------------------------------ //

// --------- Declaration --------------------- //
var srcElement = new DropDownMenu("source");
var destElement = new DropDownMenu("target");

var addBt = document.getElementById("add");
var removeBt = document.getElementById("remove");

var table = document.getElementById("table");
// ----------------------------------------- //

// --------- Event handlers ---------- //
addBt.onclick = function() {
    move(srcElement, destElement);
    destElement.sort();

    var new_tbody = document.createElement("tbody");
    new_tbody.id = "tableBody";

    for(var item = 0; item < destElement.element.options.length; ++item) {
        var row = document.createElement("tr");
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);

        cell1.innerHTML = destElement.element.options[item].innerHTML;
        cell2.innerHTML = "CELL2";

        new_tbody.appendChild(row);
    }

    var old_tbody = document.getElementById("tableBody");
    old_tbody.parentNode.replaceChild(new_tbody, old_tbody);
};

removeBt.onclick = function() {
    move(destElement, srcElement);
    srcElement.sort();
};

srcElement.element.onfocus = function() {
    destElement.deselectAll();
};

destElement.element.onfocus = function() {
    srcElement.deselectAll();
};
// ------------------------------------------ //

