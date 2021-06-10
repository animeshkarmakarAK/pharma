@extends('master::layouts.master')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <form id="chooseInventory">
                <div class="col-md-3 col-lg-2">
                    <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
                    </span>
                        <select class="form-control" id="selectSupplier">
                            <option selected disabled>Choose Supplier</option>
                            <option disabled>---------</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-2">
                    <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-record" aria-hidden="true"></span></button>
                    </span>
                        <select class="form-control" id="selectInventory">
                            <option disabled selected>Choose Inventory</option>
                            <option disabled>---------</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-9 col-lg-10">
                <div class="ngnSvgTree"></div>
            </div>
        </div>

        <div class="filterTree">

            <div class="filBox">
                <div class="btn-group text-center">
                    <button type="button" id="deleteDocs" class="btn btn-danger btn-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete Document</button>
                    <button type="button" id="allDocs" class="btn btn-primary">Hide Documents</button>
                </div>
            </div>

            <hr />

            <div class="filBox">
                <h3>Find in Tree</h3>
                <select id="searchName" class="form-control">
                    <option disabled selected>Find in Tree</option>
                </select>
            </div>

            <hr />

            <div class="filBox">
                <form>
                    <h3>Search Documents</h3>

                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control" id="typeD">
                                <option selected>All Type</option>
                                <option>--------</option>
                                <option>Invoices</option>
                                <option>Contracts</option>
                                <option>Orders</option>
                            </select>
                            <span class="input-group-addon" id="typeD" style="padding-left: 15px;">Type</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="date" class="form-control" name="fromD" id="fromD" placeholder="mm/dd/yyyy">
                            <span class="input-group-addon" id="fromD">From</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="date" class="form-control" name="toD" id="toD" placeholder="mm/dd/yyyy">
                            <span class="input-group-addon" id="toD" style="padding-left: 30px;">To</span>
                        </div>
                    </div>

                    <hr style="margin-bottom: 15px;" />

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" aria-label="..." placeholder="Start typing...">
                            <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                        </span>
                        </div>
                        <div class="newDocsGroup">
                            <a href="#" class="newDocs">First document</a>
                            <a href="#" class="newDocs">Second document</a>
                            <a href="#" class="newDocs">Third document</a>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="tree.js"></script>
    </body>
@endsection

@push('css')
    <style>
        .node circle {
            cursor: pointer;
        }

        .hideAllDocuments {
            display: none;
        }

        text {
            text-shadow: 0 1px 0 #fff, 0 -1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff;
            cursor: pointer;
        }

        .textFolder {
            fill: #000;
        }

        .btn-primary {
            background-color: #0065a5;
            color: #fff;
        }

        .node {
            cursor: pointer;
        }

        .found {
            fill: red;
            stroke: red;
        }

        .filterTree {
            border: 1px solid #ccc;
            border-width: 1px 1px 2px;
            background-color: #eee;
            position: absolute;
            top: 135px;
            right: 15px;
            width: 325px;
            border-radius: 10px;
        }

        .filterTree hr {
            border-color: #ccc;
            margin: 0;
        }

        .filBox {
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        .filBox h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 21px;
        }

        .filBox:first-of-type {
            background-color: #f7f7f7;
        }

        .newDocsGroup {
            position: relative;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-width: 1px 1px 2px;
            background-color: #fff;
            border-radius: 5px;
        }

        a.newDocs {
            color: green;
            border: none;
            display: block;
            border: 2px solid #fff;
            padding: 7px;
            position: relative;
            text-decoration: none;
            left: 0;
            top: 0;
            transition: left 0.1s ease;
            cursor: pointer;
            border-radius: 5px;
        }

        a.newDocs:hover, a.newDocsDragStarted {
            border: 2px solid #0065a5;
            background-color: #f7f7f7;
            text-decoration: none;
        }

        a.newDocs:before {
            content: '';
            display: inline-block;
            width: 12px;
            height: 12px;
            -moz-border-radius: 12px;
            -webkit-border-radius: 12px;
            border-radius: 12px;
            border: 2px solid #a1cd3a;
            background-color: #fff;
            margin-right: 12px;
        }
    </style>
@endpush

@push('js')
    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>

    <script>
        $(document).ready(function () {

            var margin = { top: 0, right: 0, bottom: 0, left: 80 };
            var width = $(window).width() - 50;
            var height = $(window).height() - 250;
            var transform = d3.zoomIdentity;

            var i = 0;
            var duration = 500;
            var root;
            var isDeleting = false;

            var hoverItem = null;
            var draggingDocument = null;

            var tree = d3.tree().size([height, width]);

            d3.select(".btn-delete")
                .on("mouseenter", function () {
                    if (draggingDocument !== null) {
                        isDeleting = true;
                        d3.select(this).style("opacity", "0.7");
                    }
                })
                .on("mouseleave", function () {
                    isDeleting = false;
                    d3.select(this).style("opacity", "1");
                });

            var svg = d3.select(".ngnSvgTree").append("svg")
                .attr("width", width)
                .attr("height", height + margin.top + margin.bottom);

            let root = {

                {
                    "ngnid": "1",
                    "Name": "USA",
                    "parent": "rootNode",
                    "IsParent": true,
                    "type": false
                },
                {
                    "ngnid": "2",
                    "Name": "Folder 1",
                    "parent": "USA",
                    "IsParent": false,
                    "type": true

                },
                {
                    "ngnid": "3",
                    "Name": "Analytics",
                    "parent": "USA",
                    "IsParent": true,
                    "type": false

                },
                {
                    "ngnid": "4",
                    "Name": "Folder 2",
                    "parent": "USA",
                    "IsParent": false,
                    "type": false
                },
                {
                    "ngnid": "5",
                    "Name": "Folder 3",
                    "parent": "USA",
                    "IsParent": false,
                    "type": false
                },
                {
                    "ngnid": "12",
                    "Name": "Folder 4",
                    "parent": "USA",
                    "IsParent": false,
                    "type": true
                },
                {
                    "ngnid": "31",
                    "Name": "Document 1",
                    "parent": "Analytics",
                    "IsParent": false,
                    "touched": true,
                    "type": true
                },
                {
                    "ngnid": "15",
                    "Name": "Document 2",
                    "parent": "Analytics",
                    "touched": false,
                    "type": true
                },
                {
                    "ngnid": "18",
                    "Name": "rootNode",
                    "IsParent": true,
                    "parent": null
                },
                {
                    "ngnid": "11",
                    "Name": "EURO",
                    "parent": "rootNode",
                    "IsParent": true,
                    "type": false
                },
                {
                    "ngnid": "21",
                    "Name": "Croatia",
                    "parent": "EURO",
                    "IsParent": true,
                    "type": false
                },
                {
                    "ngnid": "31",
                    "Name": "UK 5",
                    "parent": "EURO",
                    "IsParent": false,
                    "type": false
                },
                {
                    "ngnid": "41",
                    "Name": "UK 6",
                    "parent": "EURO",
                    "IsParent": false,
                    "type": false
                },
                {
                    "ngnid": "51",
                    "Name": "UK 7",
                    "parent": "EURO",
                    "IsParent": false,
                    "type": false
                },
                {
                    "ngnid": "71",
                    "Name": "UK 8",
                    "parent": "Croatia",
                    "IsParent": true,
                    "type": false
                },
                {
                    "ngnid": "81",
                    "Name": "UK 9",
                    "parent": "Croatia",
                    "IsParent": true,
                    "type": false
                },
                {
                    "ngnid": "01",
                    "Name": "UK 10",
                    "parent": "Croatia",
                    "IsParent": false,
                    "type": false
                },
                {
                    "ngnid": "91",
                    "Name": "UK 11",
                    "parent": "UK 9",
                    "IsParent": false,
                    "type": false
                },
                {
                    "ngnid": "5461",
                    "Name": "Document 3",
                    "parent": "UK 8",
                    "type": true
                },
                {
                    "ngnid": "2341",
                    "Name": "Document 4",
                    "parent": "UK 8",
                    "IsParent": false,
                    "type": true
                }
        };
            // Read Data from Json
            d3.json("data.json", function (error, data) {

                var select2data = $.map(data, function (obj) {
                    obj.id = obj.ngnid;
                    obj.text = obj.Name;
                    return obj;
                });

                $("#searchName").select2({
                    data: select2data,
                    placeholder: 'Select an option'
                });

                svg.append("rect")
                    .attr("width", width)
                    .attr("height", height)
                    .style("fill", "none")
                    .style("pointer-events", "all")
                    .call(d3.zoom()
                        .scaleExtent([1 / 2, 4])
                        .on("zoom", zoomed));

                var g = svg.append("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


                var stratify = d3.stratify()
                    .id(function (d) {
                        return d.Name; //This position
                    })
                    .parentId(function (d) {
                        return d.parent; //What position this position reports to
                    });

                root = stratify(data);

                root.each(function (d) {
                    d.Name = d.id; //transferring name to a name variable
                    d.id = i; //Assigning numerical Ids
                    i++;
                });

                root.x0 = height / 2;
                root.y0 = 0;

                // Collapse
                function collapse(d) {
                    if (d.children) {
                        d._children = d.children;
                        d._children.forEach(collapse);
                        d.children = null;
                    }
                }

                root.children.forEach(collapse);
                update(root);

                d3.select(self.frameElement).style("height", "800px");

                // Update Source
                function update(source) {

                    // Compute the new tree layout.
                    var nodes = tree(root).descendants();
                    var links = nodes ? nodes.slice(1) : null;

                    // Normalize for fixed-depth.
                    nodes.forEach(function (d) { d.y = d.depth * 180; });

                    // Update the nodes…
                    var node = g.selectAll("g.node")
                        .data(nodes, function (d) { return d.id || (d.id = ++i); });

                    // Enter any new nodes at the parent's previous position.
                    var nodeEnter = node.enter().append("g")
                        .attr("class", function (d) { return d.data.type ? "node nodeDocs docPart" : "node nodeFolder"; })
                        .attr("transform", function (d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
                        .on("click", toggle);

                    d3.selectAll(".nodeDocs")
                        .call(d3.drag()
                            .on("start", dragstarted)
                            .on("drag", dragged)
                            .on("end", dragended));

                    nodeEnter.append("circle")
                        .attr("r", 1e-6)
                        .attr("r", function (d) { return d.data.type ? "5" : "10"; })
                        .style("fill", colorOfEmptyFolder)
                        .attr("class", function (d) { return d.data.type ? "circleDocs" : "circleFolder"; })
                        .style("stroke", function (d) { return d.data.type ? "#a1cd3a" : "#0065a5"; })
                        .style("stroke-width", "2");

                    d3.selectAll(".circleFolder")
                        .on("mouseenter", function (d) {
                            d3.select(this).style("fill", "red");
                            hoverItem = d;
                        })
                        .on("mouseleave", function (d) {
                            hoverItem = null;
                            d3.select(this).style("fill", colorOfEmptyFolder)
                        });

                    nodeEnter.append("text")
                        .attr("dy", "5")
                        .attr("x", function (d) { return d.data.type ? 10 : 15 * -1; })
                        .attr("text-anchor", function (d) { return d.data.type ? "start" : "end"; })
                        .text(function (d) { return d.Name; })
                        .attr("class", function (d) { return d.data.type ? "textDocs" : "textFolder"; })
                        .attr("fill", function (d) { return d.data.touched ? "red" : "green"; })
                        .style("fill-opacity", 1e-6);

                    // Transition nodes to their new position.
                    var nodeUpdate = node.merge(nodeEnter).transition()
                        .duration(duration)
                        .attr("transform", function (d) { return "translate(" + d.y + "," + d.x + ")"; });

                    nodeUpdate.select("circle")
                        .transition()
                        .style("fill", function (d) {
                            if (d.class === "found") { return "red"; }
                            else { return colorOfEmptyFolder(d); }
                        })
                        .style("stroke", function (d) {
                            if (d.class === "found") { return "red"; }
                            else { return d.data.type ? "#a1cd3a" : "#0065a5"; }
                        });

                    nodeUpdate.select("text")
                        .style("fill-opacity", 1);

                    // Transition exiting nodes to the parent's new position.
                    var nodeExit = node.exit().transition()
                        .duration(duration)
                        .attr("transform", function (d) { return "translate(" + source.y + "," + source.x + ")"; })
                        .remove();

                    nodeExit.select("circle")
                        .attr("r", 1e-6);

                    nodeExit.select("text")
                        .style("fill-opacity", 1e-6);

                    // Update the links…
                    var link = g.selectAll("path.link")
                        .data(links, function (link) { var id = link.id + '->' + link.parent.id; return id; })
                        .style("stroke", function (d) {
                            if (d.class === "found") { return "#f00"; }
                            else { return "#ccc"; }
                        });

                    // Transition links to their new position.
                    link.transition()
                        .duration(duration)
                        .attr("d", connector)
                        .attr("fill", "red");

                    // Enter any new links at the parent's previous position.
                    var linkEnter = link.enter().insert("path", "g")
                        .attr("class", function (d) { return d.data.type ? "link docPart" : "link"; })
                        .style("stroke", "#ccc")
                        .attr("fill", "none")
                        .attr("d", function (d) {
                            var o = { x: source.x0, y: source.y0, parent: { x: source.x0, y: source.y0 } };
                            return connector(o);
                        });


                    // Transition links to their new position.
                    link.merge(linkEnter).transition()
                        .duration(duration)
                        .attr("d", connector);

                    // Transition exiting nodes to the parent's new position.
                    link.exit().transition()
                        .duration(duration)
                        .attr("d", function (d) {
                            var o = { x: source.x, y: source.y, parent: { x: source.x, y: source.y } };
                            return connector(o);
                        })
                        .remove();

                    // Stash the old positions for transition.
                    nodes.forEach(function (d) {
                        d.x0 = d.x;
                        d.y0 = d.y;
                    });
                }

                // Color of empty folder
                function colorOfEmptyFolder(d) {
                    if (d.children && d.children.length > 0 || d._children && d._children.length) {
                        return "#8cdbf4";
                    } else {
                        return "#fff";
                    }
                }

                // Pan and Zoom
                function zoomed() {
                    g.attr("transform", d3.event.transform);
                }

                // Clear All
                function clearAll(d) {
                    d.class = "";
                    if (d.children)
                        d.children.forEach(clearAll);
                    else if (d._children)
                        d._children.forEach(clearAll);
                }

                // Collapse All Not Found
                function collapseAllNotFound(d) {
                    if (d.children) {
                        if (d.class !== "found") {
                            d._children = d.children;
                            d._children.forEach(collapseAllNotFound);
                            d.children = null;
                        } else
                            d.children.forEach(collapseAllNotFound);
                    }
                }

                // Expand All
                function expandAll(d) {
                    if (d._children) {
                        d.children = d._children;
                        d.children.forEach(expandAll);
                        d._children = null;
                    } else if (d.children)
                        d.children.forEach(expandAll);
                }

                // Toggle children on click.
                function toggle(d) {
                    if (d.children) {
                        d._children = d.children;
                        d.children = null;
                    } else {
                        d.children = d._children;
                        d._children = null;
                    }
                    clearAll(root);
                    update(d);
                    $('#searchName').select2("val", "");
                }

                // Search Field
                var searchField = null;
                function searchTree(d) {
                    if (d.children) {
                        d.children.forEach(searchTree);
                    } else if (d._children) {
                        d._children.forEach(searchTree);
                    }
                    var searchFieldValue = eval(searchField);
                    if (searchFieldValue && searchFieldValue.match(searchText)) {
                        // Walk parent chain
                        var ancestors = [];
                        var parent = d;
                        while (typeof parent !== "undefined" && parent != null) {
                            ancestors.push(parent);
                            parent.class = "found";
                            parent = parent.parent;
                        }
                    }
                }

                // Search by Name of Document
                $("#searchName").on("select2:select", function (e) {
                    clearAll(root);
                    expandAll(root);
                    update(root);

                    searchField = "d.data.Name";
                    searchText = e.params.data.text;
                    searchTree(root);
                    root.children.forEach(collapseAllNotFound);
                    update(root);
                })

                // Koordinate linija
                function connector(d) {
                    return "M" + d.y + "," + d.x +
                        "C" + (d.y + d.parent.y) / 2 + "," + d.x +
                        " " + (d.y + d.parent.y) / 2 + "," + d.parent.x +
                        " " + d.parent.y + "," + d.parent.x;
                }

                // Drag Started
                function dragstarted(d) {
                    draggingDocument = d;
                    d3.selectAll(".docPart").style("opacity", "0.3");
                    d3.selectAll(".circleFolder").transition().attr("r", "15");
                    d3.select(this).raise().style("opacity", "1").attr("class", "node nodeDocs dragstarted");
                }

                // Dragged
                function dragged(d) {
                    d3.select(this).attr("transform", "translate(" + (d.x = d3.event.x) + "," + event.y + ")");
                }

                // Dragended
                function dragended(d) {
                    if (isDeleting) {
                        if (draggingDocument !== null) {
                            for (var i = 0; i < data.length; i++) {
                                if (data[i].id == draggingDocument.data.id) {
                                    data.splice(data[i], 1);
                                    break;
                                }
                            }

                            d3.select(".dragstarted").transition()
                                .attr("transform", "translate(" + 0 + "," + height + ")")
                                .style("opacity", "0")
                                .remove();
                            d3.selectAll('.circleFolder').style("fill", colorOfEmptyFolder);

                            var ind = d.parent.children.indexOf(d);  // broke when you ...
                            d.parent.children.splice(ind, 1);
                        }
                        clearAll(root);
                        update(root);
                    }
                    else {
                        draggingDocument = null;
                        updateDragedNode(d, hoverItem);
                    }
                    d3.selectAll(".circleFolder").attr("r", "10");
                    d3.selectAll(".docPart").style("opacity", "1");
                }

                // Update New Parent
                function updateDragedNode(item, newParent) {
                    if (newParent !== null && item.parent != newParent) {
                        var parent = item.parent;
                        item.parent = newParent;
                        item.depth = newParent.depth + 1;
                        if (typeof newParent.children === "undefined" && typeof newParent._children === "undefined") {
                            newParent.children = [];
                            newParent.children.push(item);
                        }
                        else if (newParent.children !== null) {
                            newParent.children.push(item);
                        }
                        else {
                            if (typeof newParent._children === "undefined" || newParent._children === null) {
                                newParent._children = [];
                            }
                            newParent._children.push(item);
                        }

                        var ind = -1;
                        if (parent.children) {
                            ind = parent.children.indexOf(item);
                            if (ind !== -1) {
                                parent.children.splice(ind, 1);
                                if (parent.children.length === 0) {
                                    parent.children = null;
                                }
                            }
                        }
                        else if (parent._children) {
                            ind = parent._children.indexOf(item);
                            if (ind !== -1) {
                                parent._children.splice(ind, 1);
                            }
                        }

                        item.data.parent = newParent.Name;

                        d3.selectAll('.circleFolder').style("fill", colorOfEmptyFolder);
                    }

                    clearAll(root);
                    update(root);
                }


                // ----------------------------------
                // Events outside of Tree
                // ----------------------------------

                // Button hide All docs
                function hideDocs() {
                    d3.selectAll(".docPart")
                        .classed("hideAllDocuments", function (d, i) {
                            return !d3.select(this).classed("hideAllDocuments");
                        })
                    $(this)
                        .text(function (i, text) {
                            return text === "Hide Documents" ? "Show Documents" : "Hide Documents";
                        });
                }

                document.getElementById("allDocs").addEventListener("click", hideDocs);

                // Drag new document from other enovirements
                d3.selectAll(".newDocs")
                    .call(d3.drag()
                        .on("start", NewDocdragstarted)
                        .on("drag", NewDocdragged)
                        .on("end", NewDocdragended)
                    );

                // New Document Drag Started
                function NewDocdragstarted(d) {
                    draggingDocument = d;
                    d3.selectAll(".docPart").style("opacity", "0.3");
                    d3.selectAll(".newDocs").style("opacity", "0.3");
                    d3.selectAll(".circleFolder").transition().attr("r", "15");
                    d3.select(this).attr("class", "newDocs newDocsDragStarted").style("opacity", "1");
                }

                // New Document Dragged
                function NewDocdragged(d) {
                    x = d3.event.x + 0;
                    y = d3.event.y + 0;
                    d3.select(this)
                        .style("left", x + 'px')
                        .style("top", y + 'px');
                }

                // New Document  Dragended
                function NewDocdragended(d) {
                    d3.selectAll(".docPart").style("opacity", "1");
                    d3.selectAll(".newDocs").style("opacity", "1");
                    d3.selectAll(".circleFolder").attr("r", "10");

                    if (hoverItem == null) {
                        d3.select(this).attr("class", "newDocs").style("left", "0px").style("top", "0px");
                    } else {
                        addNewDocs(d, hoverItem);
                    }
                }

                function addNewDocs(item, newDocsParent) {


                    clearAll(root);
                    update(root);
                }

            });
        });
    </script>
@endpush



