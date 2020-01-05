<template>
    <div>
        <button class="btn btn-success" data-toggle="modal" data-target="#addNew"> Add new 
        <i class="fas fa-user-plus"></i>
        </button>

            <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">Add new company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createCompany">
                <div class="modal-body">
                    <div class="form-group">
                    <input v-model="form.name" type="text" name="name"
                        placeholder="Company name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.email" type="email" name="email"
                        placeholder="Company email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.logo" type="text" name="logo"
                        placeholder="Company logo" class="form-control" :class="{ 'is-invalid': form.errors.has('logo') }">
                    <has-error :form="form" field="logo"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.website" type="text" name="website"
                        placeholder="Company website" class="form-control" :class="{ 'is-invalid': form.errors.has('website') }">
                    <has-error :form="form" field="website"></has-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data(){ 
            return{
                form: new Form({
                    name: '',
                    logo: '',
                    email: '',
                    website: '',
                })
            }
        },
        methods: {
            createCompany(){
                this.$Progress.start();
                this.form.post('company')
                .then(()=>{
                $('#addNew').modal('hide');
                toast.fire({
                        icon: 'success',
                        title: 'Added successfully'
                        })
                this.$Progress.finish();
                location.reload();
                })
                .catch(()=>{
                this.$Progress.fail();
                })
            },
        },
        created() {
            console.log('Component mounted.')
        }
    }
</script>