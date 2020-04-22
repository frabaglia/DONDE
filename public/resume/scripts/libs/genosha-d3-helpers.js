function googleColors(n) {
  var colors = ["#3366cc", "#dc3912", "#ff9900", "#109618", "#990099", "#0099c6", "#dd4477", "#66aa00", "#b82e2e", "#316395", "#994499", "#22aa99", "#aaaa11", "#6633cc", "#e67300", "#8b0707", "#651067", "#329262", "#5574a6", "#3b3eac"];
  return colors[n % colors.length];
}

function blueColors(n) {
  var colors = ["#e3f2fd", "#bbdefb", "#90caf9", "#42a5f5", "#64b5f6", "#2196f3", "#1e88e5", "#1976d2", "#1565c0", "#0d47a1"];
  return colors[n % colors.length];
}
function redColors(n) {
  var colors = ["#f44336", "#e53935", "#d32f2f", "#c62828", "#ff8a80", "#b71c1c", "#ff5252"];
  return colors[n % colors.length];
}



var opacityScale = d3.scale.quantile()
    .domain([0, 25, 50, 80, 100])
    .range([0.10, 0.25, 0.5, 0.75, 0.90]);


function clone_d3_selection(selection, i) {
    // Assume the selection contains only one object, or just work
    // on the first object. 'i' is an index to add to the id of the
    // newly cloned DOM element.
    var attr = selection.node().attributes;
    var length = attr.length;
    var node_name = selection.property("nodeName");
    var parent = d3.select(selection.node().parentNode);
    var cloned = parent.append(node_name)
                 .attr("id", selection.attr("id") + i);
    for (var j = 0; j < length; j++) { // Iterate on attributes and skip on "id"
        if (attr[j].nodeName == "id") continue;
        cloned.attr(attr[j].name,attr[j].value);
    }
    return cloned;
}