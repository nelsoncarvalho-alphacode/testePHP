import { defineStore } from 'pinia'
import axios from 'axios'


export function createGenericStore(module) {

    return defineStore({
        id: module,

        state: () => ({
            items: [],
            item: null,
        }),

        actions: {
            async fetchItems(params){
                try {
                    let url = `http://localhost:8000/api/v1/${module}`

                    const response = await axios.get(url, {headers: params} )
                    this.items = response.data
                } catch(e) {
                    console.error(`Error fetching ${module}`,e);
                } finally {
                    //loader
                }
            },

            async fetchItem(id){
                try {
                    let url = `http://localhost:8000/api/v1/${module}`

                    const response = await axios.get(`${url}/${id}`)
                    this.items = response.data
                } catch(e) {
                    console.error(`Error fetching ${module}`,e);
                } finally {
                    //loader
                }
            },

            async createItem(itemData){
                //let loader = $loading.show()
                let url = `http://localhost:8000/api/v1/${module}`
                try {
                    const response = axios.post(url, itemData)
                    console.log(response)
                    await this.fetchItems()
                } catch(e){
                    console.error(`Error creating ${module}`, e)
                } finally {
                    // loader.hide()
                }
            },

            async updateItem(id, itemData) {
                let url = `http://localhost:8000/api/v1/${module}`
                try {
                    const response = axios.put(`${url}/${id}`, itemData )
                    console.log(response.data);
                    this.fetchItems();
                } catch(e) {
                    console.error(`Error updating ${module}`, e)
                }
            },

            async deleteItem(id) {
                let url = `http://localhost:8000/api/v1/${module}`
                try {
                    const response = await axios.delete(`${url}/${id}`)
                    console.log(response);
                } catch(e) {
                    console.error(`Error deleting ${module}`, e)
                }
            }
        }
    })
}
