function move(fromOpt, toOpt) {
    var options = fromOpt.getSelected();

    for(var item = 0; item < options.length; ++item) {
        if(options[item].selected) {
            toOpt.element.add(options[item]); // move node from src to dest
        }
    }
}

function createForm(bName) {
    var row = document.createElement("tr");

    var branch = document.createElement("td");
    branch.innerHTML = bName;

    var input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("min", "1");
    input.setAttribute("max", "9999");
    input.setAttribute("name", bName + "[]");

    var floor1 = document.createElement("td");
    floor1.appendChild(input);

    var floor2 = floor1.cloneNode(true);

    row.appendChild(branch);
    row.appendChild(floor1);
    row.appendChild(floor2);

    return row;
}

function refreshTable(tbody) {
    var new_tbody = document.createElement("tbody");
    new_tbody.id = "tableBody";

    for(var item = 0; item < destElement.element.options.length; ++item) {
        var row = createForm(destElement.element.options[item].innerHTML);
        new_tbody.appendChild(row);
    }

    var old_tbody = document.getElementById("tableBody");
    old_tbody.parentNode.replaceChild(new_tbody, tbody);
}

// ---------------- Class ------------------- //
function DropDownMenu(id) {
    this.element = document.getElementById(id);
}

DropDownMenu.prototype.sort = function() {
    $("#" + this.element.id).html(
        $("#" + this.element.id + " option").sort(function (a, b) {
            var a_lowerCase = a.text.toLowerCase();
            var b_lowerCase = b.text.toLowerCase();
            return a_lowerCase == b_lowerCase ? 0 : a_lowerCase < b_lowerCase ? -1 : 1
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
var destElement = new DropDownMenu("target[]");

var addBt = document.getElementById("add");
var removeBt = document.getElementById("remove");

var submitBt = document.getElementById("submit");

// ----------------------------------------- //

// --------- Event handlers ---------- //
addBt.onclick = function() {
    move(srcElement, destElement);
    destElement.sort();

    var tbody = document.getElementById("tableBody");
    refreshTable(tbody);

    // Show/hide submit button
    if(destElement.element.options.length > 0) {
        submitBt.style.display = "block";
    }
    else
        submitBt.style.display = "none";
};

removeBt.onclick = function() {
    move(destElement, srcElement);
    srcElement.sort();

    var tbody = document.getElementById("tableBody");
    refreshTable(tbody);

    // Show/hide submit button
    if(destElement.element.options.length > 0) {
        submitBt.style.display = "block";
    }
    else
        submitBt.style.display = "none";
};

srcElement.element.onfocus = function() {
    destElement.deselectAll();
};

destElement.element.onfocus = function() {
    srcElement.deselectAll();
};

window.onload = function() {
    submitBt.style.display = "none";
};
// ------------------------------------------ //

