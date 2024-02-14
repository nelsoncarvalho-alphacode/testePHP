import { defineStore } from 'pinia'

export const useStore = defineStore('store', {
  state: () => ({
    item: {}
  }),
  // could also be defined as
  // state: () => ({ count: 0 })
  actions: {
    increment() {
      this.count++
    },
  },
})
