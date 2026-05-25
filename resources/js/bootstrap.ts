import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Theme helper: read/apply persistent theme preference
export const theme = {
	get() {
		try { return localStorage.getItem('theme'); } catch (e) { return null; }
	},
	set(value) {
		try { localStorage.setItem('theme', value); } catch (e) { }
	},
	apply(value) {
		if (value === 'dark') document.documentElement.classList.add('dark');
		else document.documentElement.classList.remove('dark');
	}
};

const __initial = theme.get();
if (__initial) theme.apply(__initial);
