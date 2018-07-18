// Initialize Firebase
// var config = {
//     apiKey: "AIzaSyD97Yo0ga2O7v5sgiaUl0-W1_oE6BXkKtk",
//     authDomain: "printer-order-6b8f0.firebaseapp.com",
//     databaseURL: "https://printer-order-6b8f0.firebaseio.com",
//     projectId: "printer-order-6b8f0",
//     storageBucket: "printer-order-6b8f0.appspot.com",
//     messagingSenderId: "913825150433"
// };

firebase.initializeApp(config);
const database = firebase.database();
const orderRef = database.ref('print-order');
var d = new Date();
const time = d.getTime();
new Vue({
    el: '#app',
    data: {
        text_input:'',
        orderData:[]
    },
    methods: {
        deleteData: function (data) {
            orderRef.child(data.ids).remove()
            // console.log(data);
        },
        printUrl:function(id){
            axios.get("/site/report",).then(res=>{
                // console.log(res)
            }).catch(e=>{

            })
        },
        Reprint(data){
            axios.get("/site/report?id="+data).then(res=>{
                location.reload();
            }).catch(e=>{

            })
        },
        Letter(data){
            axios.get("/site/addressed?id="+data).then(res=>{
             console.log("Letter")
            }).catch(e=>{

            })
        },
        SendOrder(data,key){
            const id = key;
            axios.get("/site/report?id="+data).then(res=>{
                if(res.data ==="success"){
                    orderRef.child(id).update({ status: false })
                }
            }).catch(e=>{

            })
        }
    },
    created() {

        //event หลังจากเพิ่มข้อมูลเสร็จ
        orderRef.on('child_added', shanpshot => {
          //save to messages
          this.orderData.push({
            ...shanpshot.val(),
            'ids': shanpshot.key
          });
            const  order = shanpshot.val();
            const order_id = order.id;
            if(order.status){
                this.SendOrder(order_id,shanpshot.key);
                this.Letter(order_id);
                console.log('print ='+order_id);
          }
        });
        orderRef.on('child_removed', shanpshot => {
          var deleteKey = this.orderData.find(value => value.ids == shanpshot.key)
          var index = this.orderData.indexOf(deleteKey)
          this.orderData.splice(index, 1); //delete array
        })

    }
})