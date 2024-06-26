!(function (e) {
    "object" == typeof exports && "object" == typeof module ? e(require("../../lib/codemirror")) : "function" == typeof define && define.amd ? define(["../../lib/codemirror"], e) : e(CodeMirror);
})(function (e) {
    "use strict";
    e.defineMode("javascript", function (r, t) {
        var n,
            a,
            i = r.indentUnit,
            o = t.statementIndent,
            u = t.jsonld,
            s = t.json || u,
            f = !1 !== t.trackScope,
            c = t.typescript,
            l = t.wordCharacters || /[\w$\xa1-\uffff]/,
            d = (function () {
                function e(e) {
                    return { type: e, style: "keyword" };
                }
                var r = e("keyword a"),
                    t = e("keyword b"),
                    n = e("keyword c"),
                    a = e("keyword d"),
                    i = e("operator"),
                    o = { type: "atom", style: "atom" };
                return {
                    if: e("if"),
                    while: r,
                    with: r,
                    else: t,
                    do: t,
                    try: t,
                    finally: t,
                    return: a,
                    break: a,
                    continue: a,
                    new: e("new"),
                    delete: n,
                    void: n,
                    throw: n,
                    debugger: e("debugger"),
                    var: e("var"),
                    const: e("var"),
                    let: e("var"),
                    function: e("function"),
                    catch: e("catch"),
                    for: e("for"),
                    switch: e("switch"),
                    case: e("case"),
                    default: e("default"),
                    in: i,
                    typeof: i,
                    instanceof: i,
                    true: o,
                    false: o,
                    null: o,
                    undefined: o,
                    NaN: o,
                    Infinity: o,
                    this: e("this"),
                    class: e("class"),
                    super: e("atom"),
                    yield: n,
                    export: e("export"),
                    import: e("import"),
                    extends: n,
                    await: n,
                };
            })(),
            p = /[+\-*&%=<>!?|~^@]/,
            m = /^@(context|id|value|language|type|container|list|set|reverse|index|base|vocab|graph)"/;
        function k(e, r, t) {
            return (n = e), (a = t), r;
        }
        function v(e, r) {
            var t,
                n = e.next();
            if ('"' == n || "'" == n) {
                return (
                    (r.tokenize =
                        ((t = n),
                        function (e, r) {
                            var n,
                                a = !1;
                            if (u && "@" == e.peek() && e.match(m)) return (r.tokenize = v), k("jsonld-keyword", "meta");
                            for (; null != (n = e.next()) && (n != t || a); ) a = !a && "\\" == n;
                            return a || (r.tokenize = v), k("string", "string");
                        })),
                    r.tokenize(e, r)
                );
            }
            if ("." == n && e.match(/^\d[\d_]*(?:[eE][+\-]?[\d_]+)?/)) return k("number", "number");
            if ("." == n && e.match("..")) return k("spread", "meta");
            if (/[\[\]{}\(\),;\:\.]/.test(n)) return k(n);
            if ("=" == n && e.eat(">")) return k("=>", "operator");
            else if ("0" == n && e.match(/^(?:x[\dA-Fa-f_]+|o[0-7_]+|b[01_]+)n?/)) return k("number", "number");
            else if (/\d/.test(n)) return e.match(/^[\d_]*(?:n|(?:\.[\d_]*)?(?:[eE][+\-]?[\d_]+)?)?/), k("number", "number");
            else if ("/" == n)
                return e.eat("*")
                    ? ((r.tokenize = y), y(e, r))
                    : e.eat("/")
                    ? (e.skipToEnd(), k("comment", "comment"))
                    : eJ(e, r, 1)
                    ? ((function e(r) {
                          for (var t, n = !1, a = !1; null != (t = r.next()); ) {
                              if (!n) {
                                  if ("/" == t && !a) return;
                                  "[" == t ? (a = !0) : a && "]" == t && (a = !1);
                              }
                              n = !n && "\\" == t;
                          }
                      })(e),
                      e.match(/^\b(([gimyus])(?![gimyus]*\2))+\b/),
                      k("regexp", "string-2"))
                    : (e.eat("="), k("operator", "operator", e.current()));
            else if ("`" == n) return (r.tokenize = w), w(e, r);
            else if ("#" == n && "!" == e.peek()) return e.skipToEnd(), k("meta", "meta");
            else if ("#" == n && e.eatWhile(l)) return k("variable", "property");
            else if (("<" == n && e.match("!--")) || ("-" == n && e.match("->") && !/\S/.test(e.string.slice(0, e.start)))) return e.skipToEnd(), k("comment", "comment");
            else if (p.test(n))
                return ((">" != n || !r.lexical || ">" != r.lexical.type) && (e.eat("=") ? ("!" == n || "=" == n) && e.eat("=") : /[<>*+\-|&?]/.test(n) && (e.eat(n), ">" == n && e.eat(n))), "?" == n && e.eat("."))
                    ? k(".")
                    : k("operator", "operator", e.current());
            else if (l.test(n)) {
                e.eatWhile(l);
                var a = e.current();
                if ("." != r.lastType) {
                    if (d.propertyIsEnumerable(a)) {
                        var i = d[a];
                        return k(i.type, i.style, a);
                    }
                    if ("async" == a && e.match(/^(\s|\/\*([^*]|\*(?!\/))*?\*\/)*[\[\(\w]/, !1)) return k("async", "keyword", a);
                }
                return k("variable", "variable", a);
            }
        }
        function y(e, r) {
            for (var t, n = !1; (t = e.next()); ) {
                if ("/" == t && n) {
                    r.tokenize = v;
                    break;
                }
                n = "*" == t;
            }
            return k("comment", "comment");
        }
        function w(e, r) {
            for (var t, n = !1; null != (t = e.next()); ) {
                if (!n && ("`" == t || ("$" == t && e.eat("{")))) {
                    r.tokenize = v;
                    break;
                }
                n = !n && "\\" == t;
            }
            return k("quasi", "string-2", e.current());
        }
        function b(e, r) {
            r.fatArrowAt && (r.fatArrowAt = null);
            var t = e.string.indexOf("=>", e.start);
            if (!(t < 0)) {
                if (c) {
                    var n = /:\s*(?:\w+(?:<[^>]*>|\[\])?|\{[^}]*\})\s*$/.exec(e.string.slice(e.start, t));
                    n && (t = n.index);
                }
                for (var a = 0, i = !1, o = t - 1; o >= 0; --o) {
                    var u = e.string.charAt(o),
                        s = "([{}])".indexOf(u);
                    if (s >= 0 && s < 3) {
                        if (!a) {
                            ++o;
                            break;
                        }
                        if (0 == --a) {
                            "(" == u && (i = !0);
                            break;
                        }
                    } else if (s >= 3 && s < 6) ++a;
                    else if (l.test(u)) i = !0;
                    else if (/["'\/`]/.test(u))
                        for (; ; --o) {
                            if (0 == o) return;
                            if (e.string.charAt(o - 1) == u && "\\" != e.string.charAt(o - 2)) {
                                o--;
                                break;
                            }
                        }
                    else if (i && !a) {
                        ++o;
                        break;
                    }
                }
                i && !a && (r.fatArrowAt = o);
            }
        }
        var x = { atom: !0, number: !0, variable: !0, string: !0, regexp: !0, this: !0, import: !0, "jsonld-keyword": !0 };
        function h(e, r, t, n, a, i) {
            (this.indented = e), (this.column = r), (this.type = t), (this.prev = a), (this.info = i), null != n && (this.align = n);
        }
        function g(e, r) {
            if (!f) return !1;
            for (var t = e.localVars; t; t = t.next) if (t.name == r) return !0;
            for (var n = e.context; n; n = n.prev) for (var t = n.vars; t; t = t.next) if (t.name == r) return !0;
        }
        function $(e, r, t, n, a) {
            var i = e.cc;
            for (_.state = e, _.stream = a, _.marked = null, _.cc = i, _.style = r, e.lexical.hasOwnProperty("align") || (e.lexical.align = !0); ; )
                if ((i.length ? i.pop() : s ? B : U)(t, n)) {
                    for (; i.length && i[i.length - 1].lex; ) i.pop()();
                    if (_.marked) return _.marked;
                    if ("variable" == t && g(e, n)) return "variable-2";
                    return r;
                }
        }
        var _ = { state: null, column: null, marked: null, cc: null };
        function j() {
            for (var e = arguments.length - 1; e >= 0; e--) _.cc.push(arguments[e]);
        }
        function M() {
            return j.apply(null, arguments), !0;
        }
        function A(e, r) {
            for (var t = r; t; t = t.next) if (t.name == e) return !0;
            return !1;
        }
        function V(e) {
            var r = _.state;
            if (((_.marked = "def"), f)) {
                if (r.context) {
                    if ("var" == r.lexical.info && r.context && r.context.block) {
                        var n = (function e(r, t) {
                            if (!t) return null;
                            if (t.block) {
                                var n = e(r, t.prev);
                                return n ? (n == t.prev ? t : new z(n, t.vars, !0)) : null;
                            }
                            return A(r, t.vars) ? t : new z(t.prev, new I(r, t.vars), !1);
                        })(e, r.context);
                        if (null != n) {
                            r.context = n;
                            return;
                        }
                    } else if (!A(e, r.localVars)) {
                        r.localVars = new I(e, r.localVars);
                        return;
                    }
                }
                t.globalVars && !A(e, r.globalVars) && (r.globalVars = new I(e, r.globalVars));
            }
        }
        function E(e) {
            return "public" == e || "private" == e || "protected" == e || "abstract" == e || "readonly" == e;
        }
        function z(e, r, t) {
            (this.prev = e), (this.vars = r), (this.block = t);
        }
        function I(e, r) {
            (this.name = e), (this.next = r);
        }
        var T = new I("this", new I("arguments", null));
        function S() {
            (_.state.context = new z(_.state.context, _.state.localVars, !1)), (_.state.localVars = T);
        }
        function q() {
            (_.state.context = new z(_.state.context, _.state.localVars, !0)), (_.state.localVars = null);
        }
        function C() {
            (_.state.localVars = _.state.context.vars), (_.state.context = _.state.context.prev);
        }
        function O(e, r) {
            var t = function () {
                var t = _.state,
                    n = t.indented;
                if ("stat" == t.lexical.type) n = t.lexical.indented;
                else for (var a = t.lexical; a && ")" == a.type && a.align; a = a.prev) n = a.indented;
                t.lexical = new h(n, _.stream.column(), e, null, t.lexical, r);
            };
            return (t.lex = !0), t;
        }
        function P() {
            var e = _.state;
            e.lexical.prev && (")" == e.lexical.type && (e.indented = e.lexical.indented), (e.lexical = e.lexical.prev));
        }
        function N(e) {
            function r(t) {
                return t == e ? M() : ";" == e || "}" == t || ")" == t || "]" == t ? j() : M(r);
            }
            return r;
        }
        function U(e, r) {
            if ("var" == e) return M(O("vardef", r), e$, N(";"), P);
            if ("keyword a" == e) return M(O("form"), H, U, P);
            if ("keyword b" == e) return M(O("form"), U, P);
            if ("keyword d" == e) return _.stream.match(/^\s*$/, !1) ? M() : M(O("stat"), G, N(";"), P);
            if ("debugger" == e) return M(N(";"));
            if ("{" == e) return M(O("}"), q, eu, P, C);
            if (";" == e) return M();
            if ("if" == e) return "else" == _.state.lexical.info && _.state.cc[_.state.cc.length - 1] == P && _.state.cc.pop()(), M(O("form"), H, U, P, eE);
            if ("function" == e) return M(e0);
            if ("for" == e) return M(O("form"), q, ez, U, C, P);
            if ("class" == e || (c && "interface" == r)) return (_.marked = "keyword"), M(O("form", "class" == e ? e : r), eC, P);
            if ("variable" == e) {
                if (c && "declare" == r) return (_.marked = "keyword"), M(U);
                if (c && ("module" == r || "enum" == r || "type" == r) && _.stream.match(/^\s*\w/, !1))
                    return ((_.marked = "keyword"), "enum" == r) ? M(eD) : "type" == r ? M(eS, N("operator"), ed, N(";")) : M(O("form"), e_, N("{"), O("}"), eu, P, P);
                if (c && "namespace" == r) return (_.marked = "keyword"), M(O("form"), B, U, P);
                else if (c && "abstract" == r) return (_.marked = "keyword"), M(U);
                else return M(O("stat"), ee);
            }
            return "switch" == e
                ? M(O("form"), H, N("{"), O("}", "switch"), q, eu, P, P, C)
                : "case" == e
                ? M(B, N(":"))
                : "default" == e
                ? M(N(":"))
                : "catch" == e
                ? M(O("form"), S, W, U, P, C)
                : "export" == e
                ? M(O("stat"), eN, P)
                : "import" == e
                ? M(O("stat"), eW, P)
                : "async" == e
                ? M(U)
                : "@" == r
                ? M(B, U)
                : j(O("stat"), B, N(";"), P);
        }
        function W(e) {
            if ("(" == e) return M(e8, N(")"));
        }
        function B(e, r) {
            return D(e, r, !1);
        }
        function F(e, r) {
            return D(e, r, !0);
        }
        function H(e) {
            return "(" != e ? j() : M(O(")"), G, N(")"), P);
        }
        function D(e, r, t) {
            if (_.state.fatArrowAt == _.stream.start) {
                var n = t ? X : R;
                if ("(" == e) return M(S, O(")"), ei(e8, ")"), P, N("=>"), n, C);
                if ("variable" == e) return j(S, e_, N("=>"), n, C);
            }
            var a,
                i = t ? K : J;
            return x.hasOwnProperty(e)
                ? M(i)
                : "function" == e
                ? M(e0, i)
                : "class" == e || (c && "interface" == r)
                ? ((_.marked = "keyword"), M(O("form"), eq, P))
                : "keyword c" == e || "async" == e
                ? M(t ? F : B)
                : "(" == e
                ? M(O(")"), G, N(")"), P, i)
                : "operator" == e || "spread" == e
                ? M(t ? F : B)
                : "[" == e
                ? M(O("]"), e5, P, i)
                : "{" == e
                ? eo(et, "}", null, i)
                : "quasi" == e
                ? j(L, i)
                : "new" == e
                ? M(
                      ((a = t),
                      function (e) {
                          return "." == e ? M(a ? Z : Y) : "variable" == e && c ? M(ex, a ? K : J) : j(a ? F : B);
                      })
                  )
                : M();
        }
        function G(e) {
            return e.match(/[;\}\)\],]/) ? j() : j(B);
        }
        function J(e, r) {
            return "," == e ? M(G) : K(e, r, !1);
        }
        function K(e, r, t) {
            var n = !1 == t ? J : K,
                a = !1 == t ? B : F;
            if ("=>" == e) return M(S, t ? X : R, C);
            if ("operator" == e) return /\+\+|--/.test(r) || (c && "!" == r) ? M(n) : c && "<" == r && _.stream.match(/^([^<>]|<[^<>]*>)*>\s*\(/, !1) ? M(O(">"), ei(ed, ">"), P, n) : "?" == r ? M(B, N(":"), a) : M(a);
            if ("quasi" == e) return j(L, n);
            if (";" != e) {
                if ("(" == e) return eo(F, ")", "call", n);
                if ("." == e) return M(er, n);
                if ("[" == e) return M(O("]"), G, N("]"), P, n);
                if (c && "as" == r) return (_.marked = "keyword"), M(ed, n);
                if ("regexp" == e) return (_.state.lastType = _.marked = "operator"), _.stream.backUp(_.stream.pos - _.stream.start - 1), M(a);
            }
        }
        function L(e, r) {
            return "quasi" != e ? j() : "${" != r.slice(r.length - 2) ? M(L) : M(G, Q);
        }
        function Q(e) {
            if ("}" == e) return (_.marked = "string-2"), (_.state.tokenize = w), M(L);
        }
        function R(e) {
            return b(_.stream, _.state), j("{" == e ? U : B);
        }
        function X(e) {
            return b(_.stream, _.state), j("{" == e ? U : F);
        }
        function Y(e, r) {
            if ("target" == r) return (_.marked = "keyword"), M(J);
        }
        function Z(e, r) {
            if ("target" == r) return (_.marked = "keyword"), M(K);
        }
        function ee(e) {
            return ":" == e ? M(P, U) : j(J, N(";"), P);
        }
        function er(e) {
            if ("variable" == e) return (_.marked = "property"), M();
        }
        function et(e, r) {
            if ("async" == e) return (_.marked = "property"), M(et);
            if ("variable" == e || "keyword" == _.style) {
                var t;
                return ((_.marked = "property"), "get" == r || "set" == r) ? M(en) : (c && _.state.fatArrowAt == _.stream.start && (t = _.stream.match(/^\s*:\s*/, !1)) && (_.state.fatArrowAt = _.stream.pos + t[0].length), M(ea));
            }
            if ("number" == e || "string" == e) return (_.marked = u ? "property" : _.style + " property"), M(ea);
            if ("jsonld-keyword" == e) return M(ea);
            if (c && E(r)) return (_.marked = "keyword"), M(et);
            else if ("[" == e) return M(B, es, N("]"), ea);
            else if ("spread" == e) return M(F, ea);
            else if ("*" == r) return (_.marked = "keyword"), M(et);
            else if (":" == e) return j(ea);
        }
        function en(e) {
            return "variable" != e ? j(ea) : ((_.marked = "property"), M(e0));
        }
        function ea(e) {
            return ":" == e ? M(F) : "(" == e ? j(e0) : void 0;
        }
        function ei(e, r, t) {
            function n(a, i) {
                if (t ? t.indexOf(a) > -1 : "," == a) {
                    var o = _.state.lexical;
                    return (
                        "call" == o.info && (o.pos = (o.pos || 0) + 1),
                        M(function (t, n) {
                            return t == r || n == r ? j() : j(e);
                        }, n)
                    );
                }
                return a == r || i == r ? M() : t && t.indexOf(";") > -1 ? j(e) : M(N(r));
            }
            return function (t, a) {
                return t == r || a == r ? M() : j(e, n);
            };
        }
        function eo(e, r, t) {
            for (var n = 3; n < arguments.length; n++) _.cc.push(arguments[n]);
            return M(O(r, t), ei(e, r), P);
        }
        function eu(e) {
            return "}" == e ? M() : j(U, eu);
        }
        function es(e, r) {
            if (c) {
                if (":" == e) return M(ed);
                if ("?" == r) return M(es);
            }
        }
        function ef(e, r) {
            if (c && (":" == e || "in" == r)) return M(ed);
        }
        function ec(e) {
            if (c && ":" == e) return _.stream.match(/^\s*\w+\s+is\b/, !1) ? M(B, el, ed) : M(ed);
        }
        function el(e, r) {
            if ("is" == r) return (_.marked = "keyword"), M();
        }
        function ed(e, r) {
            return "keyof" == r || "typeof" == r || "infer" == r || "readonly" == r
                ? ((_.marked = "keyword"), M("typeof" == r ? F : ed))
                : "variable" == e || "void" == r
                ? ((_.marked = "type"), M(eb))
                : "|" == r || "&" == r
                ? M(ed)
                : "string" == e || "number" == e || "atom" == e
                ? M(eb)
                : "[" == e
                ? M(O("]"), ei(ed, "]", ","), P, eb)
                : "{" == e
                ? M(O("}"), em, P, eb)
                : "(" == e
                ? M(ei(ew, ")"), ep, eb)
                : "<" == e
                ? M(ei(ed, ">"), ed)
                : "quasi" == e
                ? j(ev, eb)
                : void 0;
        }
        function ep(e) {
            if ("=>" == e) return M(ed);
        }
        function em(e) {
            return e.match(/[\}\)\]]/) ? M() : "," == e || ";" == e ? M(em) : j(ek, em);
        }
        function ek(e, r) {
            if ("variable" == e || "keyword" == _.style) return (_.marked = "property"), M(ek);
            if ("?" == r || "number" == e || "string" == e) return M(ek);
            if (":" == e) return M(ed);
            if ("[" == e) return M(N("variable"), ef, N("]"), ek);
            if ("(" == e) return j(e9, ek);
            else if (!e.match(/[;\}\)\],]/)) return M();
        }
        function ev(e, r) {
            return "quasi" != e ? j() : "${" != r.slice(r.length - 2) ? M(ev) : M(ed, ey);
        }
        function ey(e) {
            if ("}" == e) return (_.marked = "string-2"), (_.state.tokenize = w), M(ev);
        }
        function ew(e, r) {
            return ("variable" == e && _.stream.match(/^\s*[?:]/, !1)) || "?" == r ? M(ew) : ":" == e ? M(ed) : "spread" == e ? M(ew) : j(ed);
        }
        function eb(e, r) {
            return "<" == r
                ? M(O(">"), ei(ed, ">"), P, eb)
                : "|" == r || "." == e || "&" == r
                ? M(ed)
                : "[" == e
                ? M(ed, N("]"), eb)
                : "extends" == r || "implements" == r
                ? ((_.marked = "keyword"), M(ed))
                : "?" == r
                ? M(ed, N(":"), ed)
                : void 0;
        }
        function ex(e, r) {
            if ("<" == r) return M(O(">"), ei(ed, ">"), P, eb);
        }
        function eh() {
            return j(ed, eg);
        }
        function eg(e, r) {
            if ("=" == r) return M(ed);
        }
        function e$(e, r) {
            return "enum" == r ? ((_.marked = "keyword"), M(eD)) : j(e_, es, eA, eV);
        }
        function e_(e, r) {
            return c && E(r) ? ((_.marked = "keyword"), M(e_)) : "variable" == e ? (V(r), M()) : "spread" == e ? M(e_) : "[" == e ? eo(eM, "]") : "{" == e ? eo(ej, "}") : void 0;
        }
        function ej(e, r) {
            return "variable" != e || _.stream.match(/^\s*:/, !1) ? (("variable" == e && (_.marked = "property"), "spread" == e) ? M(e_) : "}" == e ? j() : "[" == e ? M(B, N("]"), N(":"), ej) : M(N(":"), e_, eA)) : (V(r), M(eA));
        }
        function eM() {
            return j(e_, eA);
        }
        function eA(e, r) {
            if ("=" == r) return M(F);
        }
        function eV(e) {
            if ("," == e) return M(e$);
        }
        function eE(e, r) {
            if ("keyword b" == e && "else" == r) return M(O("form", "else"), U, P);
        }
        function ez(e, r) {
            return "await" == r ? M(ez) : "(" == e ? M(O(")"), eI, P) : void 0;
        }
        function eI(e) {
            return "var" == e ? M(e$, eT) : "variable" == e ? M(eT) : j(eT);
        }
        function eT(e, r) {
            return ")" == e ? M() : ";" == e ? M(eT) : "in" == r || "of" == r ? ((_.marked = "keyword"), M(B, eT)) : j(B, eT);
        }
        function e0(e, r) {
            return "*" == r ? ((_.marked = "keyword"), M(e0)) : "variable" == e ? (V(r), M(e0)) : "(" == e ? M(S, O(")"), ei(e8, ")"), P, ec, U, C) : c && "<" == r ? M(O(">"), ei(eh, ">"), P, e0) : void 0;
        }
        function e9(e, r) {
            return "*" == r ? ((_.marked = "keyword"), M(e9)) : "variable" == e ? (V(r), M(e9)) : "(" == e ? M(S, O(")"), ei(e8, ")"), P, ec, C) : c && "<" == r ? M(O(">"), ei(eh, ">"), P, e9) : void 0;
        }
        function eS(e, r) {
            return "keyword" == e || "variable" == e ? ((_.marked = "type"), M(eS)) : "<" == r ? M(O(">"), ei(eh, ">"), P) : void 0;
        }
        function e8(e, r) {
            return ("@" == r && M(B, e8), "spread" == e) ? M(e8) : c && E(r) ? ((_.marked = "keyword"), M(e8)) : c && "this" == e ? M(es, eA) : j(e_, es, eA);
        }
        function eq(e, r) {
            return "variable" == e ? eC(e, r) : eO(e, r);
        }
        function eC(e, r) {
            if ("variable" == e) return V(r), M(eO);
        }
        function eO(e, r) {
            return "<" == r ? M(O(">"), ei(eh, ">"), P, eO) : "extends" == r || "implements" == r || (c && "," == e) ? ("implements" == r && (_.marked = "keyword"), M(c ? ed : B, eO)) : "{" == e ? M(O("}"), eP, P) : void 0;
        }
        function eP(e, r) {
            return "async" == e || ("variable" == e && ("static" == r || "get" == r || "set" == r || (c && E(r))) && _.stream.match(/^\s+[\w$\xa1-\uffff]/, !1))
                ? ((_.marked = "keyword"), M(eP))
                : "variable" == e || "keyword" == _.style
                ? ((_.marked = "property"), M(e1, eP))
                : "number" == e || "string" == e
                ? M(e1, eP)
                : "[" == e
                ? M(B, es, N("]"), e1, eP)
                : "*" == r
                ? ((_.marked = "keyword"), M(eP))
                : c && "(" == e
                ? j(e9, eP)
                : ";" == e || "," == e
                ? M(eP)
                : "}" == e
                ? M()
                : "@" == r
                ? M(B, eP)
                : void 0;
        }
        function e1(e, r) {
            if ("!" == r || "?" == r) return M(e1);
            if (":" == e) return M(ed, eA);
            if ("=" == r) return M(F);
            var t = _.state.lexical.prev;
            return j(t && "interface" == t.info ? e9 : e0);
        }
        function eN(e, r) {
            return "*" == r ? ((_.marked = "keyword"), M(e4, N(";"))) : "default" == r ? ((_.marked = "keyword"), M(B, N(";"))) : "{" == e ? M(ei(eU, "}"), e4, N(";")) : j(U);
        }
        function eU(e, r) {
            return "as" == r ? ((_.marked = "keyword"), M(N("variable"))) : "variable" == e ? j(F, eU) : void 0;
        }
        function eW(e) {
            return "string" == e ? M() : "(" == e ? j(B) : "." == e ? j(J) : j(eB, eF, e4);
        }
        function eB(e, r) {
            return "{" == e ? eo(eB, "}") : ("variable" == e && V(r), "*" == r && (_.marked = "keyword"), M(eH));
        }
        function eF(e) {
            if ("," == e) return M(eB, eF);
        }
        function eH(e, r) {
            if ("as" == r) return (_.marked = "keyword"), M(eB);
        }
        function e4(e, r) {
            if ("from" == r) return (_.marked = "keyword"), M(B);
        }
        function e5(e) {
            return "]" == e ? M() : j(ei(F, "]"));
        }
        function eD() {
            return j(O("form"), e_, N("{"), O("}"), ei(eG, "}"), P, P);
        }
        function eG() {
            return j(e_, eA);
        }
        function eJ(e, r, t) {
            return (r.tokenize == v && /^(?:operator|sof|keyword [bcd]|case|new|export|default|spread|[\[{}\(,;:]|=>)$/.test(r.lastType)) || ("quasi" == r.lastType && /\{\s*$/.test(e.string.slice(0, e.pos - (t || 0))));
        }
        return (
            (S.lex = q.lex = !0),
            (C.lex = !0),
            (P.lex = !0),
            {
                startState: function (e) {
                    var r = { tokenize: v, lastType: "sof", cc: [], lexical: new h((e || 0) - i, 0, "block", !1), localVars: t.localVars, context: t.localVars && new z(null, null, !1), indented: e || 0 };
                    return t.globalVars && "object" == typeof t.globalVars && (r.globalVars = t.globalVars), r;
                },
                token: function (e, r) {
                    if ((e.sol() && (r.lexical.hasOwnProperty("align") || (r.lexical.align = !1), (r.indented = e.indentation()), b(e, r)), r.tokenize != y && e.eatSpace())) return null;
                    var t = r.tokenize(e, r);
                    return "comment" == n ? t : ((r.lastType = "operator" == n && ("++" == a || "--" == a) ? "incdec" : n), $(r, t, n, a, e));
                },
                indent: function (r, n) {
                    if (r.tokenize == y || r.tokenize == w) return e.Pass;
                    if (r.tokenize != v) return 0;
                    var a,
                        u,
                        s,
                        f = n && n.charAt(0),
                        c = r.lexical;
                    if (!/^\s*else\b/.test(n))
                        for (var l = r.cc.length - 1; l >= 0; --l) {
                            var d = r.cc[l];
                            if (d == P) c = c.prev;
                            else if (d != eE && d != C) break;
                        }
                    for (; ("stat" == c.type || "form" == c.type) && ("}" == f || ((s = r.cc[r.cc.length - 1]) && (s == J || s == K) && !/^[,\.=+\-*:?[\(]/.test(n))); ) c = c.prev;
                    o && ")" == c.type && "stat" == c.prev.type && (c = c.prev);
                    var m = c.type,
                        k = f == m;
                    if ("vardef" == m) return c.indented + ("operator" == r.lastType || "," == r.lastType ? c.info.length + 1 : 0);
                    if ("form" == m && "{" == f) return c.indented;
                    if ("form" == m) return c.indented + i;
                    if ("stat" == m) return c.indented + (((a = r), (u = n), "operator" == a.lastType || "," == a.lastType || p.test(u.charAt(0)) || /[,.]/.test(u.charAt(0))) ? o || i : 0);
                    if ("switch" == c.info && !k && !1 != t.doubleIndentSwitch) return c.indented + (/^(?:case|default)\b/.test(n) ? i : 2 * i);
                    else if (c.align) return c.column + (k ? 0 : 1);
                    else return c.indented + (k ? 0 : i);
                },
                electricInput: /^\s*(?:case .*?:|default:|\{|\})$/,
                blockCommentStart: s ? null : "/*",
                blockCommentEnd: s ? null : "*/",
                blockCommentContinue: s ? null : " * ",
                lineComment: s ? null : "//",
                fold: "brace",
                closeBrackets: "()[]{}''\"\"``",
                helperType: s ? "json" : "javascript",
                jsonldMode: u,
                jsonMode: s,
                expressionAllowed: eJ,
                skipExpression: function (r) {
                    $(r, "atom", "atom", "true", new e.StringStream("", 2, null));
                },
            }
        );
    }),
        e.registerHelper("wordChars", "javascript", /[\w$]/),
        e.defineMIME("text/javascript", "javascript"),
        e.defineMIME("text/ecmascript", "javascript"),
        e.defineMIME("application/javascript", "javascript"),
        e.defineMIME("application/x-javascript", "javascript"),
        e.defineMIME("application/ecmascript", "javascript"),
        e.defineMIME("application/json", { name: "javascript", json: !0 }),
        e.defineMIME("application/x-json", { name: "javascript", json: !0 }),
        e.defineMIME("application/manifest+json", { name: "javascript", json: !0 }),
        e.defineMIME("application/ld+json", { name: "javascript", jsonld: !0 }),
        e.defineMIME("text/typescript", { name: "javascript", typescript: !0 }),
        e.defineMIME("application/typescript", { name: "javascript", typescript: !0 });
});
