import { defineStore } from 'pinia';

export const useUserStore = defineStore('userStore', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
  }),
  actions: {
    setUser(newUser) {
      this.user = newUser.user;
      this.token = newUser.token;
      localStorage.setItem('user', JSON.stringify(this.user));
      localStorage.setItem('token', this.token);
    },
    clearUser() {
      this.user = null;
      this.token = null;
      localStorage.removeItem('user');
      localStorage.removeItem('token');
    },
  },
  getters: {
    getUser: (state) => state.user,
    getToken: (state) => state.token,
  },
});
