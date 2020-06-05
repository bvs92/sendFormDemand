<template>
    <div>
        <div v-if="isLoading" style="margin-top:150px;">
            <p class="text-center mt-4">Formularul se incarca.</p>
            <rotate-square2 class="goCenter"></rotate-square2>
        </div><!-- end spinner -->
        
        <div v-else>
            <div class="alert alert-danger" role="alert" v-if="globalErrors">
                <p>{{ globalErrors }}</p>
            </div><!-- end global errors -->

            <form @submit.prevent="registerDemand" ref="formComponent"> 
                <div class="form-group">
                    <label for="category">Categorie</label>
                    <select class="form-control" id="category" v-model="category" v-if="countCategories > 0">
                        <option v-for="category in getCategories" :key="category.id" :value="category.name">{{ category.usage_name }}</option>
                    </select>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('category')">
                        <!-- from server -->
                        {{ getErrors['category'] }}
                    </div>
                </div>


                <div class="form-group">
                    <label for="postal_code">Cod postal</label>
                    <input type="numeric" class="form-control" id="postal_code" placeholder="235300" v-model="postal_code">

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('postal_code')">
                        <!-- from server -->
                        {{ getErrors['postal_code'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="city">Oras</label>
                    <input type="text" class="form-control" id="city" placeholder="Corabia" v-model="city">

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('city')">
                        <!-- from server -->
                        {{ getErrors['city'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descriere cerere</label>
                    <textarea class="form-control" name="description" id="description" rows="6" v-model="description"></textarea>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('description')">
                        <!-- from server -->
                        {{ getErrors['description'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="project_delay">Perioada de realizare</label>
                    <select class="form-control" id="project_delay" v-model="project_delay">
                        <option value="1">Urgent</option>
                        <option value="2">Peste 2 saptamani</option>
                        <option value="3">Peste 1 luna</option>
                        <option value="4">Peste 3 luni</option>
                        <option value="5">Nedefinit</option>
                    </select>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('project_delay')">
                        <!-- from server -->
                        {{ getErrors['project_delay'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Numele dvs</label>
                    <input type="text" class="form-control" id="name" placeholder="Popescu Andrei" v-model="name">

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('name')">
                        <!-- from server -->
                        {{ getErrors['name'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresa de e-mail</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" v-model="email">

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('email')">
                        <!-- from server -->
                        {{ getErrors['email'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Numar de telefon</label>
                    <input type="text" class="form-control" id="phone" placeholder="0720202020" v-model="phone">

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('phone')">
                        <!-- from server -->
                        {{ getErrors['phone'] }}
                    </div>
                </div>

                <button type="submit" 
                class="btn btn-primary btn-block send" 
                >Trimite cerere</button>
            </form>
        </div><!-- end form -->
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>

<script>
import axios from 'axios';
import {RotateSquare2} from 'vue-loading-spinner';

// TODOS
// 1. SweetAlert Toastr. => ok
// 2. Reset form after submit. => ok
// 3. VeeValidate form.
// 4. Progressbar => ok
// 5. Spinner loader when form is created/mounter. => ok
// 6. Style the page. (Tailwind Css?) => ok (fara a utiliza Tailwind)
// 7. URL Query for selecting the category when form is loading?
// 8. Use Algolia for selecting the city?

export default {
    name: 'FormComponent',
    components:{
        RotateSquare2
    },
    data(){
        return {
            categories:[],
            name: "",
            email: "",
            phone: "",
            city: "",
            postal_code: "",
            project_delay: "",
            category: "",
            description: "",
            errorsServer: [],
            globalErrors: "",
            isLoading: false
        }
    },

    methods: {

        fetchAllCategories(){
            this.resetErrors();

            return new Promise((resolve, reject) => {
                axios
                    .get('/api/categories/all')
                    .then(response => {
                        this.categories = response.data;
                        resolve(response.data);
                    })
                    .catch(err => reject(err));
            });
        },


        registerDemand(){

            this.resetErrors();
            this.$Progress.start();

            let newDemand = {
                name: this.name,
                email: this.email,
                phone: this.phone,
                city: this.city,
                postal_code: this.postal_code,
                project_delay: this.project_delay,
                category: this.category,
                description: this.description
            }

            // console.log(newDemand);

            axios
                .post('/api/demands/register', newDemand)
                .then(response => {
                    // console.log(response.data);
                    window.fireToastr('success', 'Cererea a fost trimisa cu success Multumim!');
                    this.resetForm();
                    this.$Progress.finish();
                })
                .catch(err => {

                    if(err.response.status == 501){
                        console.log(err.response);
                        this.globalErrors = err.response.data;
                    } else if(err.response.status == 500){
                        this.globalErrors = "Something went wrong. Try again later.";
                    } 
                     else if(err.response.status == 422){ 
                        // this.errorsServer = Object.values(err.response.data.errors).flat();
                        const theValues = Object.values(err.response.data.errors).flat();
                        const theKeys = Object.keys(err.response.data.errors).flat();
    
                        console.log(theValues);
                        // console.log(theKeys);
    
                        const theResult = [];
    
                        for (let i = 0; i < theKeys.length; i++) {
                            theResult[theKeys[i]] = theValues[i];
                        }
    
                        this.errorsServer = theResult;
    
                        // console.log(theResult);
                    }

                    this.$Progress.fail();
                });

            // create the controller for demands -- api
            // send request to the server /api/demands/register
        },

        checkKeyError(theKey){
            // console.log(this.getErrors[theKey]);
            if(this.getErrors[theKey] !== undefined)
                return true;
            else
                return false;
        },

        resetErrors(){
            this.errorsServer = [];
            this.globalErrors = "";
        },

        resetForm(){
            this.name = "";
            this.email = "";
            this.phone = "";
            this.city = "";
            this.postal_code = "";
            this.category = "";
            this.project_delay = "";
            this.description = "";

            this.$refs.formComponent.reset();
        },
    },
    computed: {
        countCategories(){
            return this.categories.length;
        },
        getCategories(){
            return this.categories;
        },

        getErrors(){
            return this.errorsServer;
        },

        getErrorsCount(){
            return this.errorsServer.length;
        }
    },

    beforeMount(){
        this.isLoading = true;
    },
    mounted(){
        this.fetchAllCategories().then(respnse => {
            this.isLoading = false;
        }).catch(err => console.log(err));
    },

}
</script>

<style scoped>
button.send {
    padding: 20px;font-size: 20px;font-weight: bold;
}

.goCenter{
    width: 40px;
    height: 40px;
    margin: 0 auto;
    margin-top: 60px;
}
</style>