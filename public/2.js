(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pagination.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Pagination.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuetable_2_src_components_VuetablePaginationMixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuetable-2/src/components/VuetablePaginationMixin */ "./node_modules/vuetable-2/src/components/VuetablePaginationMixin.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [vuetable_2_src_components_VuetablePaginationMixin__WEBPACK_IMPORTED_MODULE_0__["default"]]
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/specialties/index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/specialties/index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _plugins_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ~/plugins/i18n */ "./resources/js/plugins/i18n.js");
/* harmony import */ var _mixins_VuetableBootstrap_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ~/mixins/VuetableBootstrap.js */ "./resources/js/mixins/VuetableBootstrap.js");
/* harmony import */ var _FieldsSpecialties_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./FieldsSpecialties.js */ "./resources/js/pages/specialties/FieldsSpecialties.js");
/* harmony import */ var _components_Pagination_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ~/components/Pagination.vue */ "./resources/js/components/Pagination.vue");
/* harmony import */ var vuetable_2_src_components_VuetablePaginationInfo__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetable-2/src/components/VuetablePaginationInfo */ "./node_modules/vuetable-2/src/components/VuetablePaginationInfo.vue");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = ({
  middleware: 'auth',
  layout: 'DashboardLayout',
  metaInfo: function metaInfo() {
    return {
      title: this.$t('specialties.title')
    };
  },
  components: {
    VuetablePagination: _components_Pagination_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    VuetablePaginationInfo: vuetable_2_src_components_VuetablePaginationInfo__WEBPACK_IMPORTED_MODULE_5__["default"]
  },
  data: function data() {
    return {
      fields: _FieldsSpecialties_js__WEBPACK_IMPORTED_MODULE_3__["default"],
      perPage: 10,
      data: [],
      css: _mixins_VuetableBootstrap_js__WEBPACK_IMPORTED_MODULE_2__["default"],
      moreParams: {},
      sortOrder: [{
        field: 'created_at',
        direction: 'desc'
      }],
      hasNotofy: false,
      message: ''
    };
  },
  created: function created() {},
  methods: {
    onPaginationData: function onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
      this.$refs.paginationInfo.setPaginationData(paginationData);
    },
    onChangePage: function onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    onDelete: function onDelete(specialty) {
      var _this = this;

      this.$swal({
        title: "<h3>".concat(_plugins_i18n__WEBPACK_IMPORTED_MODULE_1__["default"].t('alert_delete.confirm.title'), "</h3>"),
        text: "\xBFEst\xE1s seguro de eliminar la especialidad ".concat(specialty.name, "?"),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: _plugins_i18n__WEBPACK_IMPORTED_MODULE_1__["default"].t('alert_delete.confirm.confirmButtonText'),
        cancelButtonText: _plugins_i18n__WEBPACK_IMPORTED_MODULE_1__["default"].t('alert_delete.confirm.cancelButtonText'),
        reverseButtons: true
      }).then(function (result) {
        if (result.value) {
          _this.deleteSpecialty(specialty);
        } else if (!result.isConfirmed) {
          _this.$swal({
            title: "<h3>".concat(_plugins_i18n__WEBPACK_IMPORTED_MODULE_1__["default"].t('alert_delete.cancel.title'), "</h3>"),
            text: _plugins_i18n__WEBPACK_IMPORTED_MODULE_1__["default"].t('alert_delete.cancel.text'),
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: _plugins_i18n__WEBPACK_IMPORTED_MODULE_1__["default"].t('ok'),
            timer: 5000,
            timerProgressBar: true
          });
        }
      });
    },
    deleteSpecialty: function deleteSpecialty(specialty) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var _yield$axios$delete, data;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios["delete"]("/api/specialties/".concat(specialty.id, "/delete"));

              case 2:
                _yield$axios$delete = _context.sent;
                data = _yield$axios$delete.data;
                _this2.hasNotofy = true;
                _this2.message = data.message;

                _this2.$refs.vuetable.refresh();

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  },
  computed: {
    paginationInfo: function paginationInfo() {
      return "".concat(this.$t('vuetable_record_show'), " {from} ").concat(this.$t('vuetable_record_to'), " {to} ").concat(this.$t('vuetable_record_of'), " {total} ").concat(this.$t('vuetable_items'));
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pagination.vue?vue&type=template&id=d7acf176&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Pagination.vue?vue&type=template&id=d7acf176& ***!
  \*************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("nav", [
    _c(
      "ul",
      { staticClass: "pagination" },
      [
        _c("li", { class: ["page-item", { disabled: _vm.isOnFirstPage }] }, [
          _c(
            "a",
            {
              staticClass: "page-link",
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.loadPage("prev")
                }
              }
            },
            [_c("span", [_vm._v("«")])]
          )
        ]),
        _vm._v(" "),
        _vm.notEnoughPages
          ? _vm._l(_vm.totalPage, function(n) {
              return _c(
                "li",
                {
                  key: n,
                  class: ["page-item", { active: _vm.isCurrentPage(n) }]
                },
                [
                  _c("a", {
                    staticClass: "page-link",
                    domProps: { innerHTML: _vm._s(n) },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.loadPage(n)
                      }
                    }
                  })
                ]
              )
            })
          : _vm._l(_vm.windowSize, function(n) {
              return _c(
                "li",
                {
                  key: n,
                  class: [
                    "page-item",
                    { active: _vm.isCurrentPage(_vm.windowStart + n - 1) }
                  ]
                },
                [
                  _c("a", {
                    staticClass: "page-link",
                    domProps: { innerHTML: _vm._s(_vm.windowStart + n - 1) },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.loadPage(_vm.windowStart + n - 1)
                      }
                    }
                  })
                ]
              )
            }),
        _vm._v(" "),
        _c("li", { class: ["page-item", { disabled: _vm.isOnLastPage }] }, [
          _c(
            "a",
            {
              staticClass: "page-link",
              attrs: { href: "" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.loadPage("next")
                }
              }
            },
            [_c("span", [_vm._v("»")])]
          )
        ])
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/specialties/index.vue?vue&type=template&id=1f303986&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/specialties/index.vue?vue&type=template&id=1f303986& ***!
  \***************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "container-fluid mt--7" }, [
      _c("div", { staticClass: "card shadow" }, [
        _c("div", { staticClass: "card-header border-0" }, [
          _c("div", { staticClass: "row align-items-center" }, [
            _c("div", { staticClass: "col" }, [
              _c("h3", { staticClass: "mb-0" }, [
                _vm._v(_vm._s(_vm.$t("specialties.title")))
              ])
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col text-right" },
              [
                _c(
                  "router-link",
                  {
                    staticClass: "btn btn-sm btn-success",
                    attrs: { to: { name: "specialties.create" } }
                  },
                  [
                    _vm._v(
                      "\n                            " +
                        _vm._s(_vm.$t("specialties.create")) +
                        "\n                        "
                    )
                  ]
                )
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "card-body" },
          [
            _c(
              "base-alert",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: _vm.hasNotofy,
                    expression: "hasNotofy"
                  }
                ],
                attrs: { type: "success", dismissible: "" }
              },
              [
                _c("span", { staticClass: "alert-inner--text" }, [
                  _vm._v(
                    "\n                    " +
                      _vm._s(_vm.message) +
                      "\n                    "
                  )
                ]),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "close",
                    attrs: {
                      type: "button",
                      "data-dismiss": "alert",
                      "aria-label": "Close"
                    }
                  },
                  [
                    _c("span", { attrs: { "aria-hidden": "true" } }, [
                      _vm._v("×")
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "table-responsive" },
              [
                _c("vuetable", {
                  ref: "vuetable",
                  attrs: {
                    "api-url": "/api/specialties",
                    css: _vm.css.table,
                    fields: _vm.fields,
                    "show-sort-icons": true,
                    "sort-order": _vm.sortOrder,
                    "per-page": _vm.perPage,
                    "append-params": _vm.moreParams,
                    "pagination-path": "",
                    noDataTemplate: _vm.$t("not_data_table")
                  },
                  on: { "vuetable:pagination-data": _vm.onPaginationData },
                  scopedSlots: _vm._u([
                    {
                      key: "actions",
                      fn: function(props) {
                        return _c(
                          "div",
                          {},
                          [
                            _c(
                              "router-link",
                              {
                                staticClass: "action-icon",
                                attrs: {
                                  to: {
                                    name: "specialties.edit",
                                    params: { id: props.rowData.id }
                                  }
                                }
                              },
                              [
                                _c(
                                  "span",
                                  {
                                    directives: [
                                      {
                                        name: "tooltip",
                                        rawName: "v-tooltip.top",
                                        value: {
                                          content: _vm.$t("specialties.edit"),
                                          class: "tooltip-custom"
                                        },
                                        expression:
                                          "{\n                                            content: $t('specialties.edit'), \n                                            class: 'tooltip-custom'\n                                        }",
                                        modifiers: { top: true }
                                      }
                                    ]
                                  },
                                  [
                                    _c("fa", {
                                      staticClass: "fa-lg",
                                      attrs: { icon: "pencil-alt" }
                                    })
                                  ],
                                  1
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "a",
                              {
                                staticClass: "action-icon ml-2",
                                on: {
                                  click: function($event) {
                                    return _vm.onDelete(props.rowData)
                                  }
                                }
                              },
                              [
                                _c(
                                  "span",
                                  {
                                    directives: [
                                      {
                                        name: "tooltip",
                                        rawName: "v-tooltip.top",
                                        value: {
                                          content: _vm.$t("specialties.delete"),
                                          class: "tooltip-custom"
                                        },
                                        expression:
                                          "{\n                                            content: $t('specialties.delete'), \n                                            class: 'tooltip-custom'\n                                        }",
                                        modifiers: { top: true }
                                      }
                                    ]
                                  },
                                  [
                                    _c("fa", {
                                      staticClass: "fa-lg",
                                      attrs: { icon: "trash" }
                                    })
                                  ],
                                  1
                                )
                              ]
                            )
                          ],
                          1
                        )
                      }
                    }
                  ])
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "pagination pagination-rounded mt-2 d-flex mb-0",
                attrs: { slot: "card-footer" },
                slot: "card-footer"
              },
              [
                _c("vuetable-pagination-info", {
                  ref: "paginationInfo",
                  attrs: {
                    infoTemplate: _vm.paginationInfo,
                    noDataTemplate: _vm.$t("not_data_paginate")
                  }
                }),
                _vm._v(" "),
                _c("vuetable-pagination", {
                  ref: "pagination",
                  staticClass: "ml-auto",
                  attrs: { css: _vm.css.pagination },
                  on: { "vuetable-pagination:change-page": _vm.onChangePage }
                })
              ],
              1
            )
          ],
          1
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Pagination.vue":
/*!************************************************!*\
  !*** ./resources/js/components/Pagination.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Pagination_vue_vue_type_template_id_d7acf176___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Pagination.vue?vue&type=template&id=d7acf176& */ "./resources/js/components/Pagination.vue?vue&type=template&id=d7acf176&");
/* harmony import */ var _Pagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Pagination.vue?vue&type=script&lang=js& */ "./resources/js/components/Pagination.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Pagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Pagination_vue_vue_type_template_id_d7acf176___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Pagination_vue_vue_type_template_id_d7acf176___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Pagination.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Pagination.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Pagination.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Pagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Pagination.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pagination.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Pagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Pagination.vue?vue&type=template&id=d7acf176&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Pagination.vue?vue&type=template&id=d7acf176& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Pagination_vue_vue_type_template_id_d7acf176___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Pagination.vue?vue&type=template&id=d7acf176& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pagination.vue?vue&type=template&id=d7acf176&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Pagination_vue_vue_type_template_id_d7acf176___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Pagination_vue_vue_type_template_id_d7acf176___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/mixins/VuetableBootstrap.js":
/*!**************************************************!*\
  !*** ./resources/js/mixins/VuetableBootstrap.js ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Bootstrap4 + FontAwesome Icon
/* harmony default export */ __webpack_exports__["default"] = ({
  table: {
    tableWrapper: '',
    tableHeaderClass: 'mb-0',
    tableBodyClass: 'mb-0',
    tableClass: 'table table-striped',
    loadingClass: 'loading',
    ascendingIcon: 'uil-angle-up',
    descendingIcon: 'uil-angle-down',
    sortableIcon: 'uil-sort',
    detailRowClass: 'vuetable-detail-row',
    handleIcon: 'fa fa-bars text-secondary',
    renderIcon: function renderIcon(classes, options) {
      return "<i class=\"".concat(classes.join(' '), "\"></span>");
    }
  },
  pagination: {
    wrapperClass: 'pagination float-right',
    activeClass: 'active',
    disabledClass: 'disabled',
    pageClass: 'page-item',
    linkClass: 'page-link',
    paginationClass: 'pagination',
    paginationInfoClass: 'float-left',
    dropdownClass: 'form-control',
    icons: {
      first: 'fa fa-chevron-left',
      prev: 'fa fa-chevron-left',
      next: 'fa fa-chevron-right',
      last: 'fa fa-chevron-right'
    }
  }
});

/***/ }),

/***/ "./resources/js/pages/specialties/FieldsSpecialties.js":
/*!*************************************************************!*\
  !*** ./resources/js/pages/specialties/FieldsSpecialties.js ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ([{
  name: 'name',
  title: 'Nombre'
}, {
  name: 'description',
  title: 'Descripción',
  formatter: function formatter(value) {
    return value === '' || value === null ? '--' : value;
  }
}, {
  name: 'actions',
  title: 'Acciones',
  titleClass: 'text-center',
  dataClass: 'table-action text-center'
}]);

/***/ }),

/***/ "./resources/js/pages/specialties/index.vue":
/*!**************************************************!*\
  !*** ./resources/js/pages/specialties/index.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_vue_vue_type_template_id_1f303986___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=1f303986& */ "./resources/js/pages/specialties/index.vue?vue&type=template&id=1f303986&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/pages/specialties/index.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _index_vue_vue_type_template_id_1f303986___WEBPACK_IMPORTED_MODULE_0__["render"],
  _index_vue_vue_type_template_id_1f303986___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/specialties/index.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/specialties/index.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/pages/specialties/index.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/specialties/index.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/specialties/index.vue?vue&type=template&id=1f303986&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/specialties/index.vue?vue&type=template&id=1f303986& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1f303986___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./index.vue?vue&type=template&id=1f303986& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/specialties/index.vue?vue&type=template&id=1f303986&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1f303986___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1f303986___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);