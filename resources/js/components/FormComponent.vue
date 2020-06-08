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

        <ValidationObserver ref="formComponent">
            <form @submit.prevent="registerDemand"> 
                <div v-if="hasUrlCategory">
                    <h3 style="margin: 20px 0px;">
                        Categorie: <strong>{{ selectedCategory.usage_name }}</strong>
                        <button type="button" @click="changeCategory" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h3>
                    </div>
                <!-- <div>{{ selectedCategory }}</div> -->


                <div class="form-group" v-else>
                    <label for="category">Categorie</label>
                    <validation-provider rules="required" v-slot="{ errors, invalid, valid, touched }">
                        <select class="form-control"
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}"
                         id="category" v-model="category" v-if="countCategories > 0">
                            <option v-for="category in getCategories" :key="category.id" :value="category.name">{{ category.usage_name }}</option>
                        </select>
                        <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                    </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('category')">
                        <!-- from server -->
                        {{ getErrors['category'] }}
                    </div>
                </div>


                

                <div>
                    {{ form.country.data.postcode }}
                </div>

                <div>
                    <!-- {{ form.data }} -->
                </div>

                <div class="form-group">
                    <label for="city">Oras</label>
                    <validation-provider rules="required" v-slot="{ errors, invalid, valid, touched }">

                        <places
                            v-model="form.country.label"
                            placeholder="Orasul proiectului?"
                            @change="val => { form.country.data = val }"
                            :options="options"
                            :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}"
                            >
                        </places>

                        <!-- <input type="text" class="form-control"
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}"
                         id="city" placeholder="Corabia" v-model="city"> -->
                    <!-- <input type="search" id="address-input" v-model="city" placeholder="Cauta orasul." ref="algoliaPlace" /> -->
                            <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                        </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('city')">
                        <!-- from server -->
                        {{ getErrors['city'] }}
                    </div>
                </div>



                <div class="form-group">

                    <label for="postal_code">Cod postal</label>
                    <validation-provider rules="required" v-slot="{ errors, invalid, valid, touched }">
                        <input type="numeric" class="form-control"
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}"
                         id="postal_code" placeholder="235300" v-model="form.country.data.postcode">
                        <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                    </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('postal_code')">
                        <!-- from server -->
                        {{ getErrors['postal_code'] }}
                    </div>
                </div>

                

                <div class="form-group">
                    <label for="description">Descriere cerere</label>
                    <validation-provider rules="required" v-slot="{ errors, invalid, valid, touched }">
                        <textarea class="form-control"
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}"
                         name="description" id="description" rows="6" v-model="description"></textarea>
                        <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                    </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('description')">
                        <!-- from server -->
                        {{ getErrors['description'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="project_delay">Perioada de realizare</label>
                    <validation-provider rules="required|min:0|max:5" v-slot="{ errors, invalid, valid, touched }">
                        <select class="form-control" 
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}"
                        id="project_delay" v-model.trim="project_delay">
                            <option value="1">Urgent</option>
                            <option value="2">Peste 2 saptamani</option>
                            <option value="3">Peste 1 luna</option>
                            <option value="4">Peste 3 luni</option>
                            <option value="5">Nedefinit</option>
                        </select>
                         <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                    </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('project_delay')">
                        <!-- from server -->
                        {{ getErrors['project_delay'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Numele dumneavoastra</label>
                    <validation-provider rules="required" v-slot="{ errors, invalid, valid, touched }">
                        <input type="text" class="form-control"
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}" 
                         id="name" placeholder="Popescu Andrei" v-model="name">
                        <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                    </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('name')">
                        <!-- from server -->
                        {{ getErrors['name'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresa de e-mail</label>
                    <validation-provider rules="required|email" v-slot="{ errors, invalid, valid, touched }">
                        <input type="email" class="form-control" 
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}" 
                        id="email" placeholder="name@example.com" v-model="email">
                        <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                    </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('email')">
                        <!-- from server -->
                        {{ getErrors['email'] }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Numar de telefon</label>
                    <validation-provider rules="required" v-slot="{ errors, invalid, valid, touched }">
                        <input type="text" class="form-control"
                        :class="{'is-invalid': invalid && touched, 'is-valid': valid && touched}" 
                         id="phone" placeholder="0720202020" v-model="phone">
                        <span class="text-danger" style="font-size:12px;">{{ errors[0] }}</span>
                    </validation-provider>

                    <div class="text-danger" style="font-size:12px;" v-if="checkKeyError('phone')">
                        <!-- from server -->
                        {{ getErrors['phone'] }}
                    </div>
                </div>

                <button type="submit" 
                class="btn btn-primary btn-block send shadow"
                >Trimite cerere</button>

                <p class="small py-4">Datele dvs. personale vor fi utilizate numai in contextul cererii dvs. de munca. Pentru mai multe informatii despre prelucrarea datelor dvs. personale. Prin trimiterea cererii dvs., acceptati fara rezerve conditiile noastre generale de utilizare.</p>
            </form>
        </ValidationObserver>
        </div><!-- end form -->
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios';
import {RotateSquare2} from 'vue-loading-spinner';

import Places from 'vue-places';

// TODOS
// 1. SweetAlert Toastr. => ok
// 2. Reset form after submit. => ok
// 3. VeeValidate form. => ok
// 4. Progressbar => ok
// 5. Spinner loader when form is created/mounter. => ok
// 6. Style the page. (Tailwind Css?) => ok (fara a utiliza Tailwind)
// 7. URL Query for selecting the category when form is loading? => ok
// 8. Remove selected category (click on X) and give possibility to select what you want.  => ok
// --. Use Algolia for selecting the city? Nu merge??

export default {
    name: 'FormComponent',
    components:{
        RotateSquare2,
        Places
    },

     props: {
        type: {
        type: String,
        required: false,
        },
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
            isLoading: false,
            hasUrlCategory: false,
            selectedCategory: "",


            options: {
                appId: 'pl1WYNETK3N6',
                apiKey: 'b484a3f6dd7e0360946c8cdfdda544db',
                countries: ['RO'],
            },
            form: {
                country: {
                    label: null,
                    data: {},
                },
            },


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
            
            const theCategory = this.selectedCategory ? this.selectedCategory.name : this.category;
            // console.log('Suntem la register');
            // console.log(theCategory);
            // console.log('End Suntem la register');

            let newDemand = {
                name: this.name,
                email: this.email,
                phone: this.phone,
                // city: this.city,
                city: this.form.country.label,
                // postal_code: this.postal_code,
                postal_code: this.form.country.data.postcode,
                project_delay: this.project_delay,
                category: theCategory,
                description: this.description
            }

            // console.log(newDemand);

             this.$refs.formComponent.validate().then(success => {
                 if (!success) {
                    return;
                }

                this.$Progress.start();

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

                    // Wait until the models are updated in the UI
                    this.$nextTick(() => {
                        this.$refs.formComponent.reset();
                    });


             })


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
            // this.city = "";
            this.form.country.label = "";
            // this.postal_code = "";
            this.form.country.data.postcode = "";
            this.category = "";
            this.project_delay = "";
            this.description = "";

            this.$refs.formComponent.reset();

            // Va face GET Request.
            if(this.hasUrlCategory)
                setTimeout(() => {location.href = "/form";}, 2500);

        },


        changeCategory(){
            // console.log('Change category.');
            if(this.hasUrlCategory){
                this.hasUrlCategory = false;
                this.selectedCategory = "";
            }
        }
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
         this.fetchAllCategories().then(respnse => {
            this.isLoading = false;

            const category_url = new URL(location.href).searchParams.get('categorie');

            if(category_url !== null || category_url !== undefined){
                // console.log(this.categories.flat());

                const theCat = this.getCategories.filter(elem => {
                    if(elem.name == category_url)
                        return elem;
                });

                // console.log(theCat.length);

                if(theCat.length > 0){
                    // console.log("Aici: " + theCat[0].usage_name);
                    // console.log(theCat[0]);
                    this.selectedCategory = theCat[0];
                    this.hasUrlCategory = true;
                } else {
                    this.hasUrlCategory = false;
                    // console.log(theCati[0]);
                }
    
            }
            console.log("From url: " + category_url);


        }).catch(err => console.log(err));
    },
    mounted(){
    },

    created(){
        
    }



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
    margin-top: 60px;
}
</style>