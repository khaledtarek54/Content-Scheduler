
import axios from "axios";

const instance = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000/api",
    
});
console.log("Using API base URL:", instance.defaults.baseURL);
const token = localStorage.getItem("token");
if (token) {
    instance.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

export default instance;
