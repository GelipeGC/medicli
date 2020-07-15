// Bootstrap4 + FontAwesome Icon
export default {
    table: {
        tableWrapper: '',
        tableHeaderClass: 'mb-0',
        tableBodyClass: 'mb-0',
        tableClass: 'table table-striped',
        loadingClass: 'loading',
        ascendingIcon: 'ni ni-bold-up',
        descendingIcon: 'ni ni-bold-down',
        sortableIcon: '',
        detailRowClass: 'vuetable-detail-row',
        handleIcon: 'fa fa-bars text-secondary',
        renderIcon(classes, options) {
            return `<i class="${classes.join(' ')}"></span>`
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
            last: 'fa fa-chevron-right',
        }
    }
}