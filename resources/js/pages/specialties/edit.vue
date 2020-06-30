<template>
    <div>
        
        <div class="container-fluid mt--7">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{ $t('specialties.title')}}</h3>
                    </div>
                    <div class="col text-right">
                        <router-link :to="{ name: 'specialties' }" class="btn btn-sm btn-danger">
                            {{ $t('specialties.cancel')}}
                        </router-link>
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <alert-success :form="form" :message="message"></alert-success>

                <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                    <div class="col-md-6 form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                            </div>
                            <basic-input v-model="form.name" 
                                        :class="{ 'is-invalid': form.errors.has('name') }" 
                                        :label="$t('specialties.name')" 
                                        id="name" 
                                        type="text" 
                                        name="name" />
                            <has-error :form="form" field="name" />
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <basic-input v-model="form.description" 
                                        :class="{ 'is-invalid': form.errors.has('description') }" 
                                        :label="$t('specialties.description')" 
                                        class="form-control" 
                                        type="text" 
                                        name="description" />
                            <has-error :form="form" field="description" />
                        </div>
                    </div>

                    <div class="form-group ml-3">
                            <!-- Submit Button -->
                            <v-button :loading="form.busy">
                                {{ $t('specialties.save') }}
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
    return { title: this.$t('specialties.edit') }
    },
    data() {
        return {
            form: new Form({
                id:'',
                name: '',
                description: ''
            }),
            message: ''
        }
    },
    created() {
        this.loadEditSpecialty();
    },
    methods: {
        async update ($event) {
            
          const { data } = await this.form.put(`/api/specialties/${this.$route.params.id}/update`)
            this.message = data.message;
            setTimeout(() => {
                // Redirect list.
                this.$router.push({ name: 'specialties' })
            }, 2000);
        },
        async loadEditSpecialty() {
            const { data } = await axios.get(`/api/specialties/${this.$route.params.id}/edit`)
                this.form.keys().forEach(key => {
                    this.form[key] = data.data[key]
                })
        }
    },
}
</script>