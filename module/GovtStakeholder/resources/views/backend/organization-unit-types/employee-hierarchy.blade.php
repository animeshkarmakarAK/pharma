@extends('master::layouts.master')
@push('css')
    <style>
        .node {
            cursor: pointer;
        }

        .overlay {
            background-color: #FFF;
        }

        .node text {
            font-size: 0.85em;
            font-family: 'Roboto Condensed', sans-serif;
            font-weight: 500;
        }

        .link {
            fill: none;
            stroke: #bcbcbc;
            stroke-width: 1px;
        }

        .templink {
            fill: none;
            stroke: red;
            stroke-width: 3px;
        }

        .ghostCircle.show {
            display: block;
        }

        .ghostCircle, .activeDrag .ghostCircle {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div id="tree-container">
    </div>

    <div class="modal" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Child</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row edit-add-form" method="post"
                          enctype="multipart/form-data"
                          action="#">
                        @csrf

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title_en">{{ __('Title') . '(English)' }}<span
                                        class="required"> * </span></label>
                                <input type="text" class="form-control" id="title_en"
                                       name="title_en"
                                       placeholder="{{ __('Name') }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title_bn">{{ __('Title') . '(Bangla)' }}<span
                                        class="required"> * </span></label>
                                <input type="text" class="form-control" id="title_bn"
                                       name="title_bn"
                                       placeholder="{{ __('Name') }}">
                            </div>
                        </div>

                        <input type="hidden" name="organization_id" id="organization_id"
                               value="{{ $organizationUnitType->organization_id }}">
                        <input type="hidden" name="organization_unit_type_id" id="organization_unit_type_id"
                               value="{{ $organizationUnitType->id }}">

                        @if(!empty($humanResources))
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="parent_id">{{ __('Parent') }}</label>
                                <select class="form-control select2-ajax-wizard"
                                        name="parent_id"
                                        id="parent_id"
                                        data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\HumanResourceTemplate::class)}}"
                                        data-filters="{{json_encode(['id' => ['type' => 'not-equal', 'value' => -1], 'organization_id' => $organizationUnitType->organization_id])}}"
                                        data-label-fields="{title_en}"
                                        data-placeholder="Select Parent"
                                >
                                </select>
                                <input type="text" name="parent_id" id="hidden_parent_id" hidden disabled>
                            </div>
                        </div>
                        @endif

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rank_id">{{ __('Rank') }}</label>
                                <select class="form-control select2-ajax-wizard"
                                        name="rank_id"
                                        id="rank_id"
                                        data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Rank::class)}}"
                                        data-filters="{{json_encode(['organization_id' => $organizationUnitType->organization_id])}}"
                                        data-label-fields="{title_en}"
                                        data-placeholder="Select Rank"
                                >
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="display_order">{{ __('Display Order') }}<span
                                        class="required"> * </span></label>
                                <input type="number" class="form-control" id="display_order"
                                       name="display_order"
                                       placeholder="{{ __('Display Order') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_designation">Is A Designation?<span class="required">*</span></label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="is_designation_yes"
                                           name="is_designation"
                                           value="1"
                                    >
                                    <label for="is_designation_yes" class="custom-control-label">Yes</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="is_designation_no"
                                           name="is_designation"
                                           value="0"
                                    >
                                    <label for="is_designation_no"
                                           class="custom-control-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="skill_ids">{{ __('Skills') }}</label>
                                <select class="form-control select2-ajax-wizard"
                                        multiple="multiple"
                                        name="skill_ids[]"
                                        id="skill_ids"
                                        data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Skill::class)}}"
                                        data-label-fields="{title_en}"
                                        data-placeholder="Select Skills"
                                >
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary add-modal-close-btn" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-trash"></i>Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>This is a permanent action.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="node-delete-button" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
    <script>
        let treeData = @json($humanResources);

        // Calculate total nodes, max label length
        let totalNodes = 0;
        let maxLabelLength = 0;
        // variables for drag/drop
        let selectedNode = null;
        let draggingNode = null;
        // panning variables
        let panSpeed = 200;
        let panBoundary = 20; // Within 20px from edges will pan when dragging.
        // Misc. variables
        let i = 0;
        let duration = 750;
        let root;

        // size of the diagram
        let viewerWidth, viewerHeight, height, width;
        let tree, diagonal;
        let color = ["green", "red", "cyan", "blue"];
        let zoomListener;
        let baseSvg;
        let svgGroup;


        $(document).ready(function () {
            if (!treeData) {
                $('#addModal').find('.modal-header').html('<h5 class="text-center text-capitalize">Don\'t have any human resource.Please add one!.</h5>');
                $('#addModal').find('.add-modal-close-btn').hide();
                $('#addModal').modal({backdrop: 'static', keyboard: false});
                clearModalInputFieldsValue();
                let url = "{{  route('govt_stakeholder::admin.human-resource-templates.add-node') }}";
                editAddForm.attr("action", url);
                editAddForm.attr("data-method", "POST");
                editAddForm.attr("data-is-edit", false);
                $('#addModal').modal('show');
                return 0;
            }

            viewerWidth = $(document).width() - $('.os-padding').innerWidth() - 20;
            viewerHeight = $(document).height();
            height = viewerHeight;
            width = viewerWidth;

            tree = d3.layout.tree()
                .size([viewerHeight, viewerWidth]);

            // define a d3 diagonal projection for use by the node paths later on.
            diagonal = d3.svg.diagonal()
                .projection(function (d) {
                    return [d.y, d.x];
                });

            // Call visit function to establish maxLabelLength
            visit(treeData, function (d) {
                totalNodes++;
                maxLabelLength = Math.max(d.name.length, maxLabelLength);

            }, function (d) {
                if (d.children && d.children.length > 0) {
                    open(d);
                }
                return d.children && d.children.length > 0 ? d.children : null;
            });

            // Sort the tree initially in case the JSON isn't in a sorted order.
            sortTree();

            // define the zoomListener which calls the zoom function on the "zoom" event constrained within the scaleExtents
            zoomListener = d3.behavior.zoom().scaleExtent([0.1, 3]).on("zoom", zoom);

            // define the baseSvg, attaching a class for styling and the zoomListener
            baseSvg = d3.select("#tree-container").append("svg")
                .attr("width", viewerWidth)
                .attr("height", viewerHeight)
                .attr("class", "overlay")
                .call(zoomListener)
                .on("dblclick.zoom", null);

            // Append a group which holds all nodes and which the zoom Listener can act upon.
            svgGroup = baseSvg.append("g");

            // Define the root
            root = treeData;
            root.x0 = viewerHeight / 2;
            root.y0 = 0;


            openClose(root);
            root.children.forEach(function (child) {
                openClose(child);
            })
            // Layout the tree initially and center on the root node.
            update(root);
            centerNode(root);
            expand(root);
            // open(treeData);
        })


        // A recursive helper function for performing some setup by walking through all nodes

        function visit(parent, visitFn, childrenFn) {
            if (!parent) return;

            visitFn(parent);

            let children = childrenFn(parent);
            if (children) {
                let count = children.length;
                for (let i = 0; i < count; i++) {
                    visit(children[i], visitFn, childrenFn);
                }
            }
        }


        // sort the tree according to the node names

        function sortTree() {
            tree.sort(function (a, b) {
                return b.name.toLowerCase() < a.name.toLowerCase() ? 1 : -1;
            });
        }


        function pan(domNode, direction) {
            let speed = panSpeed;
            if (panTimer) {
                clearTimeout(panTimer);
                translateCoords = d3.transform(svgGroup.attr("transform"));
                if (direction === 'left' || direction === 'right') {
                    translateX = direction === 'left' ? translateCoords.translate[0] + speed : translateCoords.translate[0] - speed;
                    translateY = translateCoords.translate[1];
                } else if (direction === 'up' || direction === 'down') {
                    translateX = translateCoords.translate[0];
                    translateY = direction === 'up' ? translateCoords.translate[1] + speed : translateCoords.translate[1] - speed;
                }
                scaleX = translateCoords.scale[0];
                scaleY = translateCoords.scale[1];
                scale = zoomListener.scale();
                svgGroup.transition().attr("transform", "translate(" + translateX + "," + translateY + ")scale(" + scale + ")");
                d3.select(domNode).select('g.node').attr("transform", "translate(" + translateX + "," + translateY + ")");
                zoomListener.scale(zoomListener.scale());
                zoomListener.translate([translateX, translateY]);
                panTimer = setTimeout(function () {
                    pan(domNode, speed, direction);
                }, 50);
            }
        }

        // Define the zoom function for the zoomable tree

        function zoom() {
            svgGroup.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
        }


        function initiateDrag(d, domNode) {
            draggingNode = d;
            d3.select(domNode).select('.ghostCircle').attr('pointer-events', 'none');
            d3.selectAll('.ghostCircle').attr('class', 'ghostCircle show');
            d3.select(domNode).attr('class', 'node activeDrag');

            svgGroup.selectAll("g.node").sort(function (a, b) { // select the parent and sort the path's
                if (a.id != draggingNode.id) return 1; // a is not the hovered element, send "a" to the back
                else return -1; // a is the hovered element, bring "a" to the front
            });
            // if nodes has children, remove the links and nodes
            if (nodes.length > 1) {
                // remove link paths
                links = tree.links(nodes);
                nodePaths = svgGroup.selectAll("path.link")
                    .data(links, function (d) {
                        return d.target.id;
                    }).remove();
                // remove child nodes
                nodesExit = svgGroup.selectAll("g.node")
                    .data(nodes, function (d) {
                        return d.id;
                    }).filter(function (d, i) {
                        if (d.id == draggingNode.id) {
                            return false;
                        }
                        return true;
                    }).remove();
            }

            // remove parent link
            parentLink = tree.links(tree.nodes(draggingNode.parent));
            svgGroup.selectAll('path.link').filter(function (d, i) {
                return d.target.id == draggingNode.id;

            }).remove();

            dragStarted = null;
        }


        // Define the drag listeners for drag/drop behaviour of nodes.
        dragListener = d3.behavior.drag()
            .on("dragstart", function (d) {
                if (d == root) {
                    return;
                }
                dragStarted = true;
                nodes = tree.nodes(d);
                d3.event.sourceEvent.stopPropagation();
                // it's important that we suppress the mouseover event on the node being dragged. Otherwise it will absorb the mouseover event and the underlying node will not detect it d3.select(this).attr('pointer-events', 'none');
            })
            .on("drag", function (d) {
                if (d == root) {
                    return;
                }

                if (dragStarted) {
                    domNode = this;
                    initiateDrag(d, domNode);
                }

                // get coords of mouseEvent relative to svg container to allow for panning
                relCoords = d3.mouse($('svg').get(0));
                if (relCoords[0] < panBoundary) {
                    panTimer = true;
                    pan(this, 'left');
                } else if (relCoords[0] > ($('svg').width() - panBoundary)) {

                    panTimer = true;
                    pan(this, 'right');
                } else if (relCoords[1] < panBoundary) {
                    panTimer = true;
                    pan(this, 'up');
                } else if (relCoords[1] > ($('svg').height() - panBoundary)) {
                    panTimer = true;
                    pan(this, 'down');
                } else {
                    try {
                        clearTimeout(panTimer);
                    } catch (e) {

                    }
                }

                d.x0 += d3.event.dy;
                d.y0 += d3.event.dx;
                let node = d3.select(this);
                node.attr("transform", "translate(" + d.y0 + "," + d.x0 + ")");
                updateTempConnector();
            }).on("dragend", function (d) {
                if (d == root) {
                    return;
                }
                domNode = this;

                if (selectedNode) {
                    // now remove the element from the parent, and insert it into the new elements children
                    let index = draggingNode?.parent?.children?.indexOf(draggingNode);
                    if (index > -1) {
                        draggingNode.parent.children.splice(index, 1);
                    }
                    if (selectedNode.children || selectedNode._children) {
                        if (selectedNode.children) {
                            selectedNode.children.push(draggingNode);
                        } else {
                            selectedNode._children.push(draggingNode);
                        }
                    } else {
                        selectedNode.children = [];
                        selectedNode.children.push(draggingNode);
                    }

                    // Make sure that the node being added to is expanded so user can see added node is correctly moved
                    expand(selectedNode);
                    sortTree();
                    endDrag();
                } else {
                    endDrag();
                }
            });

        async function endDrag() {
            if (selectedNode && draggingNode) {
                try {
                    let response = await updateNodeOnDrag(selectedNode.id, draggingNode.id);
                } catch (e) {
                    console.log(e.message)
                }
            }

            selectedNode = null;
            d3.selectAll('.ghostCircle').attr('class', 'ghostCircle');
            d3.select(domNode).attr('class', 'node');
            // now restore the mouseover event or we won't be able to drag a 2nd time
            d3.select(domNode).select('.ghostCircle').attr('pointer-events', '');
            // updateTempConnector();
            if (draggingNode !== null) {
                update(root);
                // centerNode(draggingNode);
                draggingNode = null;
            }
        }

        // Helper functions for collapsing and expanding nodes.

        function collapse(d) {
            if (Array.isArray(d.children) && d.children.length > 0) {
                d._children = d.children;
                d._children.forEach(collapse);
                d.children = null;
            }
        }

        function expand(d) {
            if (Array.isArray(d._children) && d._children.length > 0) {
                d.children = d._children;
                d.children.forEach(expand);
                d._children = null;
            }
        }

        let overCircle = function (d) {
            selectedNode = d;
            updateTempConnector();
        };
        let outCircle = function (d) {
            selectedNode = null;
            updateTempConnector();
        };

        // Function to update the temporary connector indicating dragging affiliation
        let updateTempConnector = function () {
            let data = [];
            if (draggingNode !== null && selectedNode !== null) {
                // have to flip the source coordinates since we did this for the existing connectors on the original tree
                data = [{
                    source: {
                        x: selectedNode.y0,
                        y: selectedNode.x0
                    },
                    target: {
                        x: draggingNode.y0,
                        y: draggingNode.x0
                    }
                }];
            }
            let link = svgGroup.selectAll(".templink").data(data);

            link.enter().append("path")
                .attr("class", "templink")
                .attr("d", d3.svg.diagonal())
                .attr('pointer-events', 'none');

            link.attr("d", d3.svg.diagonal());

            link.exit().remove();
        };

        // Function to center node when clicked/dropped so node doesn't get lost when collapsing/moving with large amount of children.

        function centerNode(source) {
            scale = zoomListener.scale();
            x = -source.y0 + viewerHeight / 4;
            y = -source.x0 + viewerHeight / 4;
            x = x * scale;
            y = y * scale;
            d3.select('g').transition()
                .duration(duration)
                .attr("transform", "translate(" + x + "," + y + ")scale(" + scale + ")");
            zoomListener.scale(scale);
            zoomListener.translate([x, y]);
        }

        // Toggle children function

        function toggleChildren(d) {
            if (d.children) {
                d._children = d.children;
                d.children = null;
            } else if (d._children) {
                d.children = d._children;
                d._children = null;
            }
            return d;
        }

        function openClose(d, open = true) {
            if (open) {
                if (d._children) {
                    d.children = d._children;
                    d._children = null;
                }
            } else {
                if (d.children) {
                    d._children = d.children;
                    d.children = null;
                }
            }
            return d;
        }


        function open(myNode) {
            toggleChildren(myNode);
            if (myNode.children) {
                myNode.children.forEach(function (j) {
                    open(j);
                })
            }
            if (myNode._children) {
                myNode._children.forEach(function (j) {
                    open(j);
                })
            }
        }

        // Toggle children on click.

        function click(d) {
            if (d3.event.defaultPrevented) return; // click suppressed
            d = toggleChildren(d);
            closeOpenedActionButtons();
            update(d);
        }

        function addNode(parent, newNode) {
            if (parent?.children?.length > 0) {
                parent.children.push(newNode);
            } else if (parent?._children?.length > 0) {
                parent._children.push(newNode);
            } else {
                let children = [];
                children.push(newNode);
                parent.children = children;
                delete parent._children;
            }
            update(parent);
            // expand(parent);
            // sortTree();
        }

        function updateNodeOnDrag(parentId, childId) {
            return $.ajax({
                method: 'POST',
                url: "{{route('govt_stakeholder::admin.human-resource-templates.update-node-on-drag', '__')}}".replace('__', childId),
                data: {
                    parent_id: parentId,
                }
            });
        }


        function removeNode(d) {
            //this is the links target node which you want to remove
            let target = d;
            //make new set of children
            let children = [];
            if (!target.parent.children && target.parent._children) {
                target.parent.children = target.parent._children;
            }
            target.parent.children.forEach(function (child) {
                if (child.id != target.id) {
                    //add to the child list if target id is not same
                    //so that the node target is removed.
                    children.push(child);
                }
            });
            //set the target parent with new set of children sans the one which is removed
            target.parent.children = children;
            //redraw the parent since one of its children is removed
            update(d.parent)
        }


        function update(source) {
            // Compute the new height, function counts total children of root node and sets tree height accordingly.
            // This prevents the layout looking squashed when new nodes are made visible or looking sparse when nodes are removed
            // This makes the layout more consistent.
            console.table("source", source);

            let levelWidth = [1];
            let childCount = function (level, n) {
                if (n.children && n.children.length > 0) {
                    if (levelWidth.length <= level + 1) levelWidth.push(0);

                    levelWidth[level + 1] += n.children.length;
                    n.children.forEach(function (d) {
                        childCount(level + 1, d);
                    });
                }
            };
            childCount(0, root);
            let newHeight = d3.max(levelWidth) * 100; // change tree nodes height
            tree = tree.size([newHeight, viewerWidth]);

            // Compute the new tree layout.
            let nodes = tree.nodes(root).reverse(),
                links = tree.links(nodes);


            // Set widths between levels based on maxLabelLength.
            nodes.forEach(function (d) {
                // d.y = (d.depth * (maxLabelLength * 30)); //maxLabelLength * 10px
                // alternatively to keep a fixed scale one can set a fixed depth per level
                // Normalize for fixed-depth by commenting out below line
                d.y = (d.depth * 500); //500px per level.
            });

            // Update the nodes…
            node = svgGroup.selectAll("g.node")
                .data(nodes, function (d) {
                    return d.id || (d.id = ++i);
                });

            // Normalize for fixed-depth.
            nodes.forEach(function (d) {
                if (d.depth == 1) {
                    d.y = d.depth * 180;
                } else {
                    d.y = d.depth * 220;
                }
            });

            //coloring links
            d3.selectAll('.link').style("stroke", function (d) {
                return color[d.source.depth];
            });

            // Enter any new nodes at the parent's previous position.
            let nodeEnter = node.enter().append("g")
                .call(dragListener)
                .attr("class", "node")
                .attr("transform", function (d) {
                    return "translate(" + source.y0 + "," + source.x0 + ")";
                });


            nodeEnter.append("circle")
                .attr('class', 'nodeCircle')
                .attr("r", 4.5)
                .style("stroke-width", "1")
                .style("stroke", "red")
                .style("fill", function (d) {
                    return d._children ? "#EEB4B4" : "#FFF";
                });

            // phantom node to give us mouseover in a radius around it
            nodeEnter.append("circle")
                .attr("class", "ghostCircle")
                .attr("r", 30)
                .attr("opacity", 0.2) // change this to zero to hide the target area
                .style("fill", "#EEB4B4")
                .attr("pointer-events", "mouseover")
                .on("mouseover", function (node) {
                    overCircle(node);
                })
                .on("mouseout", function (node) {
                    outCircle(node);
                });


            let textGroup = nodeEnter.append("g");
            let rects = textGroup.append("rect");

            let texts = textGroup.append("text")
                .text(function (d) {
                    return d.name;
                })
                .style("fill-stroke", "#fff")
                .on("mouseover", function (d) {
                    d3.select(this)
                        .transition()
                        .duration(100)
                        .attr("fill", "red");
                })
                .on("mouseout", function (d) {
                    d3.select(this)
                        .transition()
                        .duration(100)
                        .attr("fill", "#fff");
                })
                .each(function (d) {
                    d.width = this.getBBox().width;
                })
                .attr("text-anchor", function (d) {
                    // return "start";
                    return d.children || d._children ? "end" : "start";
                })
                .attr("x", function (d) {
                    return 10;
                    // return d.children || d._children ? -10 : 10;
                })
                .attr("dy", "0.30em")
                .style("fill-opacity", 1e-6)
                .style('opacity', 0);

            nodeEnter.append('g')
                .attr("class", "node-text")
                .append("text")
                .text(function (d) {
                    return d.name;
                })
                .attr("x", 8)
                .attr("dy", "0.35em")
                .style("fill", "#fff")
                .style("z-index", -1)
                .on("click", click);


            //first node rectangle
            rects.attr("x", function (d) {
                return 5;
            })
                .attr("r", 1e-6)
                .attr("y", "-0.5em")
                .attr("height", "1.2em")
                .style("fill", function (d) {
                    let haveChildren = false;
                    if (d.children) {
                        haveChildren = d.children.length > 0;
                    }
                    if (d._children) {
                        haveChildren = d._children.length > 0;
                    }
                    return haveChildren ? "#138D75" : "green";
                })
                .style("fill-opacity", 1e-6)
                .style("z-index", -1)
                .attr("width", function (d) {
                    return d.width + 5;
                })
                .on("click", click);

            let actionGroup = nodeEnter.append('g');
            let actionButton = textGroup.append("rect")
                .attr("class", "action-button")
                .attr("height", 19)
                .attr("width", 20)
                .attr("x", function (d) {
                    return d.width + 10;
                })
                .attr("y", -8)
                .attr("id", function (d) {
                    return d.id;
                })
                .style("fill", function (d) {
                    return "yellow";
                })
                .on("click", function (d) {
                    sortTree();
                    toggleActionButtons(d3.select(this.parentNode), d);
                });


            textGroup.append("a")
                .append('text')
                .attr("class", "action-button-text")
                .attr("text-anchor", "right")
                .attr("x", function (d) {
                    return d.width + 12;
                })
                .attr("y", 5)
                .attr("id", function (d) {
                    return d.id;
                })
                .text("+/-")
                .style("fill", "#000")
                .on("click", function (d) {
                    sortTree();
                    toggleActionButtons(d3.select(this.parentNode.parentNode), d);
                })

            // action button -- add button
            textGroup.append("path")
                .attr("class", "add-button")
                .attr("d", function () {
                    return "M-66,-20 h-25 q-5,0 -5,5 v10 q0,5 5,5 h25 z"
                })
                .style("fill", "#3333cc")
                .style("opacity", 0)
                .on("click", function (d) {
                    showModal(d3.select(this), $('#addModal'), false, d);
                });

            // action button -- add button text
            textGroup.append("text")
                .attr("class", "add-button-text")
                .text("Add")
                .attr("x", -93)
                .attr("y", -5)
                .style("opacity", 0)
                .style("fill", "#ffffff")
                .on("click", function (d) {
                    showModal(d3.select(this), $('#addModal'), false, d);
                });

            // action button -- edit button
            textGroup.append("rect")
                .attr("class", "edit-button")
                .attr("x", -66)
                .attr("y", -20)
                .attr("width", 30)
                .attr("height", 20)
                .style("fill", "#ffff00")
                .style("opacity", 0)
                .style("z-index", 999)
                .on("click", function (d) {
                    showModal(d3.select(this), $('#addModal'), true, d);
                });

            // action button -- edit button text
            textGroup.append("text")
                .attr("class", "edit-button-text")
                .text("Edit")
                .attr("x", -66)
                .attr("y", -5)
                .style("opacity", 0)
                .style("fill", "#000")
                .style("z-index", 999)
                .on("click", function (d) {
                    showModal(d3.select(this), $('#addModal'), true, d);
                });

            // action button -- delete button
            textGroup.append("path")
                .attr("class", "delete-button")
                .attr("d", function () {
                    return "M-38,-20 h40 q5,0 5,5 v10 q0,5 -5,5 h-40 z"
                })
                .style("fill", "#ff0000")
                .style("opacity", 0)
                .style("z-index", 999)
                .on("click", function (d) {
                    deleteNode(d3.select(this), d);
                })

            // action button -- delete button text
            textGroup.append("text")
                .attr("class", "delete-button-text")
                .text("Delete")
                .attr("x", -35)
                .attr("y", -5)
                .style("opacity", 0)
                .style("fill", "#fff")
                .on("click", function (d) {
                    deleteNode(d3.select(this), d);
                });


            // Update the text to reflect whether node has children or not.
            node.select("text")
                .attr("x", function (d) {
                    return d.children || d._children ? -10 : 10;
                })
                .attr("text-anchor", function (d) {
                    return d.children || d._children ? "end" : "start";
                })
                .text(function (d) {
                    return d.name;
                });

            // Change the circle fill depending on whether it has children and is collapsed
            node.select("circle.nodeCircle")
                .attr("r", 4.5)
                .style("fill", function (d) {
                    return d._children ? "#EEB4B4" : "#FFF";
                });


            // Transition nodes to their new position.
            let nodeUpdate = node.transition()
                .duration(duration)
                .attr("transform", function (d) {
                    return "translate(" + d.y + "," + d.x + ")";
                });

            // Fade the text in
            nodeUpdate.select("text")
                .style("fill-opacity", 1);
            nodeUpdate.select("rect")
                .style("fill-opacity", 0.9);

            // Transition exiting nodes to the parent"s new position.
            let nodeExit = node.exit().transition()
                .duration(duration)
                .attr("transform", function (d) {
                    return "translate(" + source.y + "," + source.x + ")";
                })
                .remove();

            nodeExit.select("circle")
                .attr("r", 0);

            nodeExit.select("text")
                .style("fill-opacity", 0);
            nodeExit.select("rect")
                .style("fill-opacity", 0);

            // Update the links…
            let link = svgGroup.selectAll("path.link")
                .data(links, function (d) {
                    return d.target.id;
                });

            // Enter any new links at the parent"s previous position.
            link.enter().insert("path", "g")
                .attr("class", "link")
                .attr("d", function (d) {
                    let o = {
                        x: source.x0,
                        y: source.y0
                    };
                    return diagonal({
                        source: o,
                        target: o
                    });
                });

            // Transition links to their new position.
            link.transition()
                .duration(duration)
                .attr("d", diagonal);

            // Transition exiting nodes to the parent"s new position.
            link.exit().transition()
                .duration(duration)
                .attr("d", function (d) {
                    let o = {
                        x: source.x,
                        y: source.y
                    };
                    return diagonal({
                        source: o,
                        target: o
                    });
                })
                .remove();

            // Stash the old positions for transition.
            nodes.forEach(function (d) {
                d.x0 = d.x;
                d.y0 = d.y;
            });
        }


        function toggleButton(ele, eleClass) {
            if (eleClass.match(/show/)) {
                ele.attr("class", eleClass.replaceAll("show", ""));
                ele.style("opacity", 0);
            } else {
                ele.attr("class", eleClass + " show");
                ele.style("opacity", 1);
            }
        }

        function canDelete(nodeEle, nodeData) {
            if (!nodeData?.children?.length && !nodeData?._children?.length && !nodeData?.parent) {
                return false;
            }
            return !((nodeData?.children?.length || nodeData?._children?.length));
        }

        function toggleActionButtons(d, currentNode) {

            //close other button if opened  except d->current opened button
            closeOpenedActionButtons(currentNode);

            let addButton = d.selectAll(".add-button");
            let editButton = d.selectAll(".edit-button");

            toggleButton(addButton, addButton.attr("class"));
            toggleButton(editButton, editButton.attr("class"));

            let addButtonText = d.selectAll(".add-button-text");
            let editButtonText = d.selectAll(".edit-button-text");
            let deleteButtonText = d.selectAll(".delete-button-text");

            toggleButton(addButtonText, addButtonText.attr("class"));
            toggleButton(editButtonText, editButtonText.attr("class"));

            let deleteButton = d.selectAll(".delete-button");

            if (canDelete(deleteButton, currentNode)) {
                toggleButton(deleteButton, deleteButton.attr("class"));
                toggleButton(deleteButtonText, deleteButtonText.attr("class"));
            }
        }

        function closeActionButton(ele) {
            let eleClass = ele.attr("class");
            if (eleClass.match(/show/)) {
                ele.attr("class", eleClass.replaceAll("show", ""));
                ele.style("opacity", 0);
            }
        }

        function closeOpenedActionButtons(currentNode = false) {
            d3.selectAll('.add-button').each(function (d) {
                if (currentNode && d.id == currentNode.id) {
                    return;
                }
                let parentNode = d3.select(this.parentNode);
                let addButtonEle = parentNode.select('.add-button');
                let editButtonEle = parentNode.select('.edit-button');
                let deleteButtonEle = parentNode.select('.delete-button');
                let addButtonTextEle = parentNode.select('.add-button-text');
                let editButtonTextEle = parentNode.select('.edit-button-text');
                let deleteButtonTextEle = parentNode.select('.delete-button-text');
                closeActionButton(addButtonEle);
                closeActionButton(editButtonEle);
                closeActionButton(deleteButtonEle);
                closeActionButton(addButtonTextEle);
                closeActionButton(editButtonTextEle);
                closeActionButton(deleteButtonTextEle);
            });
        }


        function showModal(btnEle, modal, edit = false, nodeData = false) {
            if (edit) {
                $('#addModal').find('.modal-title').text("Edit Node");

                //set the fields with current value
                $('#title_en').val(nodeData.title_en);
                $('#title_bn').val(nodeData.title_bn);

                $('#parent_id').data('filters', {
                    id: {
                        type: "not-equal",
                        value: nodeData.id
                    }
                });

                if (nodeData.parent_id) {
                    $('#parent_id').append(new Option(nodeData?.parent?.title_en, nodeData?.parent?.id, true, true)).trigger('change');
                    $('#parent_id').parent().parent().css('display', 'block');
                } else {
                    $('#parent_id').parent().parent().css('display', 'none');
                }
                if (nodeData.rank_id) {
                    $('#rank_id').append(new Option(nodeData.rank_id, nodeData?.rank_id, true, true)).trigger('change');
                }
                $('#display_order').val(nodeData.display_order);
                $("input[name=is_designation][value=" + nodeData.is_designation + "]").attr('checked', 'checked');

                // change form url for edit
                let url = "{{route('govt_stakeholder::admin.human-resource-templates.update-node', '__')}}".replace('__', nodeData.id);

                editAddForm.attr("action", url);
                editAddForm.attr("data-method", "PATCH");
                editAddForm.attr("data-node-id", nodeData.id);
                editAddForm.attr("data-is-edit", true);
            } else {
                $('#addModal').find('.modal-title').text("Add a new child");
                clearModalInputFieldsValue();
                let url = "{{  route('govt_stakeholder::admin.human-resource-templates.add-node') }}";
                editAddForm.attr("action", url);
                editAddForm.attr("data-method", "POST");
                editAddForm.attr("data-node-id", nodeData.id);
                editAddForm.attr("data-is-edit", false);

                if (nodeData.id) {
                    $('#parent_id').append(new Option(nodeData?.title_en, nodeData?.id, true, true)).trigger('change');
                }
                $('#parent_id').parent().parent().hide();
            }

            if (btnEle.style("opacity") == 1) {
                modal.modal('show');
            }
        }

        function deleteNode(nodeEle, d) {
            let isActive = nodeEle.style("opacity") == 1;
            if ((d?.children?.length || d?._children?.length) && isActive) {
                alert('You can\'t delete this node');
            } else if (isActive) {
                $('#deleteModal').find('.modal-header').show();
                $('#deleteModal').find('.modal-body').text("This is a permanent action");
                $('#deleteModal').find('.modal-footer').show();
                $('#deleteModal').modal('show');
                let url = "{{ route('govt_stakeholder::admin.human-resource-templates.delete-node', '__') }}".replace('__', d.id);
                $('#deleteModal').attr("data-url", url);
                $('#deleteModal').attr("data-node-id", d.id);
            }
        }


        function clearModalInputFieldsValue() {
            $('#title_en').val(null).trigger('change');
            $('#title_bn').val(null).trigger('change');
            $('#parent_id').val(null).trigger('change');
            $('#rank_id').val(null).trigger('change');
            $('#display_order').val(null).trigger('change');
            $("#is_designation_yes").prop('checked', false);
            $("#is_designation_no").prop('checked', false);
        }

        const editAddForm = $('.edit-add-form');

        editAddForm.validate({
            errorElement: "em",
            onkeyup: false,
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                element.parents(".form-group").addClass("has-feedback");

                if (element.parents(".form-group").length) {
                    error.insertAfter(element.parents(".form-group").first().children().last());
                } else if (element.hasClass('select2') || element.hasClass('select2-ajax-custom') || element.hasClass('select2-ajax')) {
                    error.insertAfter(element.parents(".form-group").first().find('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                $(element).closest('.help-block').remove();
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            },
            rules: {
                title_en: {
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,191}$",
                },
                organization_id: {
                    required: true,
                },
                organization_unit_type_id: {
                    required: true,
                },
                "skill_ids[]": {
                    required: false,
                },
                display_order: {
                    required: true,
                    min: 0,
                },
                is_designation: {
                    required: true,
                },
            },
            messages: {
                title_bn: {
                    pattern: "This field is required in Bangla.",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                // htmlForm.submit();
            }
        });


        //search in data tree
        function searchTree(root, searchNodeId) {
            if (root.id == searchNodeId) {
                return root;
            } else if (root.children != null || root._children != null) {
                let i;
                let result = null;
                let children = root.children ? root.children : root._children;
                for (i = 0; result == null && i < children.length; i++) {
                    result = searchTree(children[i], searchNodeId);
                }
                return result;
            }
            return null;
        }

        $(document).ready(function () {

            $('#hidden_parent_id').val($('#parent_id').val()).prop('disabled', false);
            $('#parent_id').on('change', function () {
                $('#hidden_parent_id').val($('#parent_id').val()).prop('disabled', false);
            })


            editAddForm.submit(async function (event) {
                // Stop form from submitting normally
                event.preventDefault();

                // when there is no tree data -- human resource template

                let edit, responseNodeData, currentNode;
                if (root) {
                     edit = editAddForm.attr('data-is-edit') == "true";
                     currentNode = searchTree(root, editAddForm.attr('data-node-id')); // this is parent for add
                }


                // Get some values from elements on the page:
                const $form = $(this),
                    url = $form.attr("action"),
                    methodType = $(this).attr("data-method");

                // Send the data using post
                try {
                    const responseData = await $.post(url, $(this).serialize())
                        .done(function ({nodeData}) {
                            responseNodeData = nodeData;
                            if (!edit && root) {
                                addNode(currentNode, responseNodeData);
                            } else if (edit && root) {
                                editNode(currentNode, responseNodeData);
                            }else {
                                //refresh page
                                location.reload();
                            }
                        })
                        .fail(function () {
                            console.log("update failed");
                        })
                        .always(function () {
                            $('#addModal').modal("hide");
                            closeOpenedActionButtons();
                        })
                } catch (e) {
                    console.log(e.message);
                }

            });

            function editNode(currentNode, respondedNodeData) {
                if (currentNode?.parent && currentNode?.parent?.id != respondedNodeData.parent_id) { // if parent id updated then push the child to new parent
                    let parent = searchTree(root, respondedNodeData.parent_id);
                    let nodeData = searchTree(root, respondedNodeData.id);

                    if (parent) {
                        removeNode(currentNode);
                        addNode(parent, nodeData);
                    } else {
                        alert("Error to Edit: Parent does not exist");
                    }
                } else {
                    let tmpResponseNodeData = respondedNodeData;
                    currentNode.title_en = tmpResponseNodeData.title_en;
                    currentNode.title_bn = tmpResponseNodeData.title_bn;
                    currentNode.name = tmpResponseNodeData.name;
                    currentNode.is_designation = tmpResponseNodeData.is_designation;
                    currentNode.display_order = tmpResponseNodeData.display_order;
                    currentNode.rank_id = tmpResponseNodeData.rank_id;
                    console.table("current node: ", currentNode);
                    update(currentNode);
                }
            }

            const deleteBtn = $('#node-delete-button');
            deleteBtn.on("click", async function () {
                try {
                    let url = $('#deleteModal').attr('data-url');
                    if (url?.length <= 0) {
                        throw Error('Delete url not found.');
                    }
                    let response = await $.get(url)
                        .done(function (response) {

                            if (response.alertType == "error") {
                                $('#deleteModal').find('.modal-header').css("display", 'none');
                                $('#deleteModal').find('.modal-body').text(response.message);
                                $('#deleteModal').find('.modal-footer').hide();
                                $('#deleteModal').modal("show");
                            } else {
                                $('#deleteModal').modal("hide");
                                let deletedNode = searchTree(root, $('#deleteModal').attr('data-node-id'));
                                removeNode(deletedNode);
                            }
                        })
                        .fail(function () {
                            console.log("delete operation failed");
                        })
                        .always(function () {
                            closeOpenedActionButtons();
                        })
                } catch (e) {
                    console.table(...e)
                }
            });
        })
    </script>
@endpush
