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
                        <router-link :to="{ name: 'doctors' }" class="btn btn-sm btn-danger">
                            {{ $t('doctors.cancel')}}
                        </router-link>
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <alert-success :form="form" :message="message"></alert-success>

                <form @submit.prevent="create" @keydown="form.onKeydown($event)">
                    <div class="form-group col-md-6 mb-3">
                        <label class="font-weight-bold">{{ $t('doctors.name') }}*</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                            </div>

                            <basic-input v-model="form.name" 
                                        :class="{ 'is-invalid': form.errors.has('name') }" 
                                        :label="$t('doctors.name')" 
                                        id="name" 
                                        type="text" 
                                        name="name" />
                            <has-error :form="form" field="name" />
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">{{ $t('doctors.email') }}*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <basic-input v-model="form.email" 
                                        :class="{ 'is-invalid': form.errors.has('email') }" 
                                        :label="$t('doctors.email')" 
                                        class="form-control" 
                                        type="email" 
                                        name="email" />
                            <has-error :form="form" field="email" />
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">{{ $t('doctors.cedula') }}*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <basic-input v-model="form.cedula" 
                                        :class="{ 'is-invalid': form.errors.has('cedula') }" 
                                        :label="$t('doctors.cedula')" 
                                        class="form-control" 
                                        type="cedula" 
                                        name="cedula" />
                            <has-error :form="form" field="cedula" />
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">{{ $t('doctors.address') }}</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <basic-input v-model="form.address" 
                                        :class="{ 'is-invalid': form.errors.has('address') }" 
                                        :label="$t('doctors.address')" 
                                        class="form-control" 
                                        type="address" 
                                        name="address" />
                            <has-error :form="form" field="address" />
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">{{ $t('doctors.phone') }}*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <basic-input v-model="form.phone" 
                                        :class="{ 'is-invalid': form.errors.has('phone') }" 
                                        :label="$t('doctors.phone')" 
                                        class="form-control" 
                                        type="phone" 
                                        name="phone" />
                            <has-error :form="form" field="phone" />
                        </div>
                    </div>
                    <div class="form-group ml-3">
                            <!-- Submit Button -->
                            <v-button :loading="form.busy">
                                {{ $t('doctors.save') }}
                            </v-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
import Form from 'vform'
export default {
    middleware: 'auth',
    layout: 'DashboardLayout',
    metaInfo () {
    return { title: this.$t('doctors.create') }
    },
    data() {
        return {
            form: new Form({
                name: '',
                description: ''
            }),
            message: ''
        }
    },
    methods: {
        async create ($event) {
            
            const { data } = await this.form.post('/api/doctors/store')
            this.message = data.message;
            setTimeout(() => {
                // Redirect list.
                this.$router.push({ name: 'doctors' })
            }, 2000);
        }
    }
}
</script>