import axios from "axios";
export const getData = async () => {
    try {
        const res = await axios.get("/api/getData");
        return res.data;
    } catch (err) {
        console.log(err);
    }
};
export const getMenu = async () => {
    try {
        const res = await axios.get("/api/getMenu");
        return res.data;
    } catch (err) {
        throw err
    }
};
export const postData = async (payload) => {
    try {
        const res = await axios.post("/api/postData",payload);
        return res.data;
    } catch (err) {
        console.log(err);
    }
};
export const putData = async (id, payload) => {
  
        try {
            const res = await axios.put(`api/putData/${id}`, payload);
            return res.data;
        } catch (err) {
            console.error(err);
            throw err;
        }
    };


export const deleteData = async (id) => {
    try {
        const res = await axios.delete("/api/deleteData",id);
        return res.data;
    } catch (err) {
        console.log(err);
    }
};
export const putMenu = async (id, data) => {
    try {
        const res = await axios.put("/api/putMenu/"+id,{stok:data});
        return res.data;
    } catch (err) {
        console.log(err);
    }
};

export const deletePesanan = async (id) =>{
    try{
        const res = await axios.delete("/api/deletePesanan/"+id);
        return res.data;
    }catch(err){
        console.log(err);
    }
}