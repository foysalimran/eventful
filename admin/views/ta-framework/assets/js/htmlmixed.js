!(function (t) {
    "object" == typeof exports && "object" == typeof module
        ? t(require("../../lib/codemirror"), require("../xml/xml"), require("../javascript/javascript"), require("../css/css"))
        : "function" == typeof define && define.amd
        ? define(["../../lib/codemirror", "../xml/xml", "../javascript/javascript", "../css/css"], t)
        : t(CodeMirror);
})(function (t) {
    "use strict";
    var e = {
            script: [
                ["lang", /(javascript|babel)/i, "javascript"],
                ["type", /^(?:text|application)\/(?:x-)?(?:java|ecma)script$|^module$|^$/i, "javascript"],
                ["type", /./, "text/plain"],
                [null, null, "javascript"],
            ],
            style: [
                ["lang", /^css$/i, "css"],
                ["type", /^(text\/)?(x-)?(stylesheet|css)$/i, "css"],
                ["type", /./, "text/plain"],
                [null, null, "css"],
            ],
        },
        a = {};
    function n(t, e) {
        var n,
            l,
            o = t.match((l = a[(n = e)]) || (a[n] = RegExp("\\s+" + n + "\\s*=\\s*('|\")?([^'\"]+)('|\")?\\s*")));
        return o ? /^\s*(.*?)\s*$/.exec(o[2])[1] : "";
    }
    function l(t, e) {
        return RegExp((e ? "^" : "") + "</\\s*" + t + "\\s*>", "i");
    }
    function o(t, e) {
        for (var a in t) for (var n = e[a] || (e[a] = []), l = t[a], o = l.length - 1; o >= 0; o--) n.unshift(l[o]);
    }
    t.defineMode(
        "htmlmixed",
        function (a, c) {
            var i = t.getMode(a, { name: "xml", htmlMode: !0, multilineTagIndentFactor: c.multilineTagIndentFactor, multilineTagIndentPastTag: c.multilineTagIndentPastTag, allowMissingTagName: c.allowMissingTagName }),
                r = {},
                s = c && c.tags,
                u = c && c.scriptTypes;
            if ((o(e, r), s && o(s, r), u)) for (var m = u.length - 1; m >= 0; m--) r.script.unshift(["type", u[m].matches, u[m].mode]);
            function d(e, o) {
                var c,
                    s = i.token(e, o.htmlState),
                    u = /\btag\b/.test(s);
                if (u && !/[<>\s\/]/.test(e.current()) && (c = o.htmlState.tagName && o.htmlState.tagName.toLowerCase()) && r.hasOwnProperty(c)) o.inTag = c + " ";
                else if (o.inTag && u && />$/.test(e.current())) {
                    var m = /^([\S]+) (.*)/.exec(o.inTag);
                    o.inTag = null;
                    var g =
                            ">" == e.current() &&
                            (function t(e, a) {
                                for (var l = 0; l < e.length; l++) {
                                    var o = e[l];
                                    if (!o[0] || o[1].test(n(a, o[0]))) return o[2];
                                }
                            })(r[m[1]], m[2]),
                        p = t.getMode(a, g),
                        f = l(m[1], !0),
                        h = l(m[1], !1);
                    (o.token = function (t, e) {
                        var a, n, l, o, c;
                        return t.match(f, !1)
                            ? ((e.token = d), (e.localState = e.localMode = null), null)
                            : ((a = t), (n = h), (l = e.localMode.token(t, e.localState)), (c = (o = a.current()).search(n)) > -1 ? a.backUp(o.length - c) : o.match(/<\/?$/) && (a.backUp(o.length), a.match(n, !1) || a.match(o)), l);
                    }),
                        (o.localMode = p),
                        (o.localState = t.startState(p, i.indent(o.htmlState, "", "")));
                } else o.inTag && ((o.inTag += e.current()), e.eol() && (o.inTag += " "));
                return s;
            }
            return {
                startState: function () {
                    return { token: d, inTag: null, localMode: null, localState: null, htmlState: t.startState(i) };
                },
                copyState: function (e) {
                    var a;
                    return e.localState && (a = t.copyState(e.localMode, e.localState)), { token: e.token, inTag: e.inTag, localMode: e.localMode, localState: a, htmlState: t.copyState(i, e.htmlState) };
                },
                token: function (t, e) {
                    return e.token(t, e);
                },
                indent: function (e, a, n) {
                    return !e.localMode || /^\s*<\//.test(a) ? i.indent(e.htmlState, a, n) : e.localMode.indent ? e.localMode.indent(e.localState, a, n) : t.Pass;
                },
                innerMode: function (t) {
                    return { state: t.localState || t.htmlState, mode: t.localMode || i };
                },
            };
        },
        "xml",
        "javascript",
        "css"
    ),
        t.defineMIME("text/html", "htmlmixed");
});
