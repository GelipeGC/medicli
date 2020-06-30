export default [{
        name: 'name',
        title: 'Nombre'
    },
    {
        name: 'description',
        title: 'Descripción',
        formatter(value) {
            return (value === '' || value === null) ? '--' : value
        }
    },
    {
        name: 'actions',
        title: 'Acciones',
        titleClass: 'text-center',
        dataClass: 'table-action text-center'
    }
]