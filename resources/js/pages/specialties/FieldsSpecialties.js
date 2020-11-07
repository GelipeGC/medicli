import moment from "moment"

export default [{
        name: 'name',
        title: 'Nombre',
        sortField: 'name'
    },
    {
        name: 'description',
        title: 'Descripción',
        sortField: 'description',
        formatter(value) {
            return (value === '' || value === null) ? '--' : value
        }
    },
    {
        name: 'created_at',
        title: 'Fecha creación',
        sortField: 'created_at',
        formatter(value) {
            return moment(value, 'YYYY-MM-DD').locale('es').format('MMM DD, YYYY')

        }
    },
    {
        name: 'actions',
        title: 'Acciones',
        titleClass: 'text-center',
        dataClass: 'table-action text-center'
    }
]