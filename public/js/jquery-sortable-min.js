!function (d, B, m, f) {
    function v(a, b) { var c = Math.max(0, a[0] - b[0], b[0] - a[1]), e = Math.max(0, a[2] - b[1], b[1] - a[3]); return c + e } function w(a, b, c, e) { var k = a.length; e = e ? "offset" : "position"; for (c = c || 0; k--;) { var g = a[k].el ? a[k].el : d(a[k]), l = g[e](); l.left += parseInt(g.css("margin-left"), 10); l.top += parseInt(g.css("margin-top"), 10); b[k] = [l.left - c, l.left + g.outerWidth() + c, l.top - c, l.top + g.outerHeight() + c] } } function p(a, b) { var c = b.offset(); return { left: a.left - c.left, top: a.top - c.top } } function x(a, b, c) {
        b = [b.left, b.top]; c =
            c && [c.left, c.top]; for (var e, k = a.length, d = []; k--;)e = a[k], d[k] = [k, v(e, b), c && v(e, c)]; return d = d.sort(function (a, b) { return b[1] - a[1] || b[2] - a[2] || b[0] - a[0] })
    } function q(a) { this.options = d.extend({}, n, a); this.containers = []; this.options.rootGroup || (this.scrollProxy = d.proxy(this.scroll, this), this.dragProxy = d.proxy(this.drag, this), this.dropProxy = d.proxy(this.drop, this), this.placeholder = d(this.options.placeholder), a.isValidTarget || (this.options.isValidTarget = f)) } function s(a, b) {
        this.el = a; this.options = d.extend({},
            z, b); this.group = q.get(this.options); this.rootGroup = this.options.rootGroup || this.group; this.handle = this.rootGroup.options.handle || this.rootGroup.options.itemSelector; var c = this.rootGroup.options.itemPath; this.target = c ? this.el.find(c) : this.el; this.target.on(t.start, this.handle, d.proxy(this.dragInit, this)); this.options.drop && this.group.containers.push(this)
    } var z = { drag: !0, drop: !0, exclude: "", nested: !0, vertical: !0 }, n = {
        afterMove: function (a, b, c) { }, containerPath: "", containerSelector: "ol, ul", distance: 0, delay: 0,
        handle: "", itemPath: "", itemSelector: "li", bodyClass: "dragging", draggedClass: "dragged", isValidTarget: function (a, b) { return !0 }, onCancel: function (a, b, c, e) { }, onDrag: function (a, b, c, e) { a.css(b) }, onDragStart: function (a, b, c, e) { a.css({ height: a.outerHeight(), width: a.outerWidth() }); a.addClass(b.group.options.draggedClass); d("body").addClass(b.group.options.bodyClass) }, onDrop: function (a, b, c, e) { a.removeClass(b.group.options.draggedClass).removeAttr("style"); d("body").removeClass(b.group.options.bodyClass) }, onMousedown: function (a,
            b, c) { if (!c.target.nodeName.match(/^(input|select|textarea)$/i)) return c.preventDefault(), !0 }, placeholderClass: "placeholder", placeholder: '<li class="placeholder"></li>', pullPlaceholder: !0, serialize: function (a, b, c) { a = d.extend({}, a.data()); if (c) return [b]; b[0] && (a.children = b); delete a.subContainers; delete a.sortable; return a }, tolerance: 0
    }, r = {}, y = 0, A = { left: 0, top: 0, bottom: 0, right: 0 }, t = {
        start: "touchstart.sortable mousedown.sortable", drop: "touchend.sortable touchcancel.sortable mouseup.sortable", drag: "touchmove.sortable mousemove.sortable",
        scroll: "scroll.sortable"
    }; q.get = function (a) { r[a.group] || (a.group === f && (a.group = y++), r[a.group] = new q(a)); return r[a.group] }; q.prototype = {
        dragInit: function (a, b) { this.$document = d(b.el[0].ownerDocument); var c = d(a.target).closest(this.options.itemSelector); c.length && (this.item = c, this.itemContainer = b, !this.item.is(this.options.exclude) && this.options.onMousedown(this.item, n.onMousedown, a) && (this.setPointer(a), this.toggleListeners("on"), this.setupDelayTimer(), this.dragInitDone = !0)) }, drag: function (a) {
            if (!this.dragging) {
                if (!this.distanceMet(a) ||
                    !this.delayMet) return; this.options.onDragStart(this.item, this.itemContainer, n.onDragStart, a); this.item.before(this.placeholder); this.dragging = !0
            } this.setPointer(a); this.options.onDrag(this.item, p(this.pointer, this.item.offsetParent()), n.onDrag, a); a = this.getPointer(a); var b = this.sameResultBox, c = this.options.tolerance; (!b || b.top - c > a.top || b.bottom + c < a.top || b.left - c > a.left || b.right + c < a.left) && !this.searchValidTarget() && (this.placeholder.detach(), this.lastAppendedItem = f)
        }, drop: function (a) {
            this.toggleListeners("off");
            this.dragInitDone = !1; if (this.dragging) { if (this.placeholder.closest("html")[0]) this.placeholder.before(this.item).detach(); else this.options.onCancel(this.item, this.itemContainer, n.onCancel, a); this.options.onDrop(this.item, this.getContainer(this.item), n.onDrop, a); this.clearDimensions(); this.clearOffsetParent(); this.lastAppendedItem = this.sameResultBox = f; this.dragging = !1 }
        }, searchValidTarget: function (a, b) {
            a || (a = this.relativePointer || this.pointer, b = this.lastRelativePointer || this.lastPointer); for (var c =
                x(this.getContainerDimensions(), a, b), e = c.length; e--;) { var d = c[e][0]; if (!c[e][1] || this.options.pullPlaceholder) if (d = this.containers[d], !d.disabled) { if (!this.$getOffsetParent()) { var g = d.getItemOffsetParent(); a = p(a, g); b = p(b, g) } if (d.searchValidTarget(a, b)) return !0 } } this.sameResultBox && (this.sameResultBox = f)
        }, movePlaceholder: function (a, b, c, e) { var d = this.lastAppendedItem; if (e || !d || d[0] !== b[0]) b[c](this.placeholder), this.lastAppendedItem = b, this.sameResultBox = e, this.options.afterMove(this.placeholder, a, b) },
        getContainerDimensions: function () { this.containerDimensions || w(this.containers, this.containerDimensions = [], this.options.tolerance, !this.$getOffsetParent()); return this.containerDimensions }, getContainer: function (a) { return a.closest(this.options.containerSelector).data(m) }, $getOffsetParent: function () {
            if (this.offsetParent === f) {
                var a = this.containers.length - 1, b = this.containers[a].getItemOffsetParent(); if (!this.options.rootGroup) for (; a--;)if (b[0] != this.containers[a].getItemOffsetParent()[0]) { b = !1; break } this.offsetParent =
                    b
            } return this.offsetParent
        }, setPointer: function (a) { a = this.getPointer(a); if (this.$getOffsetParent()) { var b = p(a, this.$getOffsetParent()); this.lastRelativePointer = this.relativePointer; this.relativePointer = b } this.lastPointer = this.pointer; this.pointer = a }, distanceMet: function (a) { a = this.getPointer(a); return Math.max(Math.abs(this.pointer.left - a.left), Math.abs(this.pointer.top - a.top)) >= this.options.distance }, getPointer: function (a) {
            var b = a.originalEvent || a.originalEvent.touches && a.originalEvent.touches[0];
            return { left: a.pageX || b.pageX, top: a.pageY || b.pageY }
        }, setupDelayTimer: function () { var a = this; this.delayMet = !this.options.delay; this.delayMet || (clearTimeout(this._mouseDelayTimer), this._mouseDelayTimer = setTimeout(function () { a.delayMet = !0 }, this.options.delay)) }, scroll: function (a) { this.clearDimensions(); this.clearOffsetParent() }, toggleListeners: function (a) { var b = this; d.each(["drag", "drop", "scroll"], function (c, e) { b.$document[a](t[e], b[e + "Proxy"]) }) }, clearOffsetParent: function () { this.offsetParent = f }, clearDimensions: function () { this.traverse(function (a) { a._clearDimensions() }) },
        traverse: function (a) { a(this); for (var b = this.containers.length; b--;)this.containers[b].traverse(a) }, _clearDimensions: function () { this.containerDimensions = f }, _destroy: function () { r[this.options.group] = f }
    }; s.prototype = {
        dragInit: function (a) { var b = this.rootGroup; !this.disabled && !b.dragInitDone && this.options.drag && this.isValidDrag(a) && b.dragInit(a, this) }, isValidDrag: function (a) { return 1 == a.which || "touchstart" == a.type && 1 == a.originalEvent.touches.length }, searchValidTarget: function (a, b) {
            var c = x(this.getItemDimensions(),
                a, b), e = c.length, d = this.rootGroup, g = !d.options.isValidTarget || d.options.isValidTarget(d.item, this); if (!e && g) return d.movePlaceholder(this, this.target, "append"), !0; for (; e--;)if (d = c[e][0], !c[e][1] && this.hasChildGroup(d)) { if (this.getContainerGroup(d).searchValidTarget(a, b)) return !0 } else if (g) return this.movePlaceholder(d, a), !0
        }, movePlaceholder: function (a, b) {
            var c = d(this.items[a]), e = this.itemDimensions[a], k = "after", g = c.outerWidth(), f = c.outerHeight(), h = c.offset(), h = {
                left: h.left, right: h.left + g, top: h.top,
                bottom: h.top + f
            }; this.options.vertical ? b.top <= (e[2] + e[3]) / 2 ? (k = "before", h.bottom -= f / 2) : h.top += f / 2 : b.left <= (e[0] + e[1]) / 2 ? (k = "before", h.right -= g / 2) : h.left += g / 2; this.hasChildGroup(a) && (h = A); this.rootGroup.movePlaceholder(this, c, k, h)
        }, getItemDimensions: function () { this.itemDimensions || (this.items = this.$getChildren(this.el, "item").filter(":not(." + this.group.options.placeholderClass + ", ." + this.group.options.draggedClass + ")").get(), w(this.items, this.itemDimensions = [], this.options.tolerance)); return this.itemDimensions },
        getItemOffsetParent: function () { var a = this.el; return "relative" === a.css("position") || "absolute" === a.css("position") || "fixed" === a.css("position") ? a : a.offsetParent() }, hasChildGroup: function (a) { return this.options.nested && this.getContainerGroup(a) }, getContainerGroup: function (a) {
            var b = d.data(this.items[a], "subContainers"); if (b === f) {
                var c = this.$getChildren(this.items[a], "container"), b = !1; c[0] && (b = d.extend({}, this.options, { rootGroup: this.rootGroup, group: y++ }), b = c[m](b).data(m).group); d.data(this.items[a],
                    "subContainers", b)
            } return b
        }, $getChildren: function (a, b) { var c = this.rootGroup.options, e = c[b + "Path"], c = c[b + "Selector"]; a = d(a); e && (a = a.find(e)); return a.children(c) }, _serialize: function (a, b) { var c = this, e = this.$getChildren(a, b ? "item" : "container").not(this.options.exclude).map(function () { return c._serialize(d(this), !b) }).get(); return this.rootGroup.options.serialize(a, e, b) }, traverse: function (a) { d.each(this.items || [], function (b) { (b = d.data(this, "subContainers")) && b.traverse(a) }); a(this) }, _clearDimensions: function () {
            this.itemDimensions =
                f
        }, _destroy: function () { var a = this; this.target.off(t.start, this.handle); this.el.removeData(m); this.options.drop && (this.group.containers = d.grep(this.group.containers, function (b) { return b != a })); d.each(this.items || [], function () { d.removeData(this, "subContainers") }) }
    }; var u = {
        enable: function () { this.traverse(function (a) { a.disabled = !1 }) }, disable: function () { this.traverse(function (a) { a.disabled = !0 }) }, serialize: function () { return this._serialize(this.el, !0) }, refresh: function () { this.traverse(function (a) { a._clearDimensions() }) },
        destroy: function () { this.traverse(function (a) { a._destroy() }) }
    }; d.extend(s.prototype, u); d.fn[m] = function (a) { var b = Array.prototype.slice.call(arguments, 1); return this.map(function () { var c = d(this), e = c.data(m); if (e && u[a]) return u[a].apply(e, b) || this; e || a !== f && "object" !== typeof a || c.data(m, new s(c, a)); return this }) }
}(jQuery, window, "sortable");