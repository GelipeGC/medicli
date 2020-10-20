<template>
<div>
    <div class="container-fluid mt--7">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{ $t('doctors.title')}}</h3>
                    </div>
                    <div class="col text-right">
                        <router-link :to="{ name: 'doctors.create' }" class="btn btn-sm btn-success">
                            {{ $t('doctors.create')}}
                        </router-link>
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <base-alert type="success" dismissible v-show="hasNotofy">
                    <span class="alert-inner--text">
                    {{ message }}
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </base-alert>
                <div class="table-responsive">
                    <vuetable ref="vuetable" 
                            api-url="/api/doctors" 
                            :css="css.table" 
                            :fields="fields"
                            :show-sort-icons="true"
                            :sort-order="sortOrder" 
                            :per-page="perPage" 
                            :append-params="moreParams"
                            pagination-path=""
                            :noDataTemplate="$t('not_data_table')"
                            @vuetable:pagination-data="onPaginationData"
                    >
                        <div slot="actions" slot-scope="props">
                            <router-link :to="{ name: 'doctors.edit', params: { id: props.rowData.id}}" 
                                        class="action-icon">
                                <span v-tooltip.top="{
                                            content: $t('doctors.edit'), 
                                            class: 'tooltip-custom'
                                        }">
                                    <fa icon="pencil-alt" class="fa-lg"/>
                                    <i class="fa fa-sort" aria-hidden="true"></i>

                                </span>
                            </router-link>
                            <a class="action-icon ml-2"   
                                @click="onDelete(props.rowData)">
                                <span v-tooltip.top="{
                                            content: $t('doctors.delete'), 
                                            class: 'tooltip-custom'
                                        }">
                                    <fa icon="trash" class="fa-lg"/>
                                 </span>
                            </a>
                        </div>                       
                    </vuetable>

                </div>
                <div class="pagination pagination-rounded mt-2 d-flex mb-0" slot="card-footer">
                    <vuetable-pagination-info ref="paginationInfo"
                        :infoTemplate="paginationInfo"
                        :noDataTemplate="$t('not_data_paginate')"
                        ></vuetable-pagination-info>
                    <vuetable-pagination ref="pagination" 
                                            @vuetable-pagination:change-page="onChangePage" 
                                            :css="css.pagination"
                                            class="ml-auto"
                                            >
                    </vuetable-pagination>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import i18n from '~/plugins/i18n'
import CssConfig from '~/mixins/VuetableBootstrap.js'
import FieldsDoctors from './FieldsDoctors.js'
import VuetablePagination from "~/components/Pagination.vue";
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';

export default {
    middleware: 'auth',
    layout: 'DashboardLayout',
    metaInfo() {
        return {
            title: this.$t('doctors.title')
        }
    },
    components: {
        VuetablePagination,
        VuetablePaginationInfo,
    },
    data() {
        return {
            fields: FieldsDoctors,
            perPage: 10,
            data: [],
            css: CssConfig,
            moreParams: {},
            sortOrder: [
                {
                field: 'created_at',
                direction: 'desc'
                }
            ],
            hasNotofy: false,
            message: ''
        }
    },
    created() {
    },
    methods: {
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData);
            this.$refs.paginationInfo.setPaginationData(paginationData);
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page);
        },
        onDelete(specialty){
            this.$swal(
                {
                    title: `<h3>${i18n.t('alert_delete.confirm.title')}</h3>`,
                    text: `¿Estás seguro de eliminar la especialidad ${specialty.name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: i18n.t('alert_delete.confirm.confirmButtonText'),
                    cancelButtonText: i18n.t('alert_delete.confirm.cancelButtonText'),
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        this.deleteSpecialty(specialty);
                    } else if (!result.isConfirmed) {
                        this.$swal({
                            title: `<h3>${i18n.t('alert_delete.cancel.title')}</h3>`,
                            text: i18n.t('alert_delete.cancel.text'),
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonText: i18n.t('ok'),
                            timer: 5000,
                            timerProgressBar: true,
                        })
                    }
                });
        },
        async deleteSpecialty(specialty) {
            const { data } = await axios.delete(`/api/doctors/${specialty.id}/delete`)
            this.hasNotofy = true;
            this.message = data.message;
            this.$refs.vuetable.refresh();
        }
    },
    computed: {
        paginationInfo() {
            return `${this.$t('vuetable_record_show')} {from} ${this.$t('vuetable_record_to')} {to} ${this.$t('vuetable_record_of')} {total} ${this.$t('vuetable_items')}`;
        }
    },
}
</script>
