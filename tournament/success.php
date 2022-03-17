<?php
    print_r($_REQUEST);
    $status = $_POST['status'];
    $txnid = $_POST['txnid'];
    $username = $_POST['firstname'];
    $email = $_POST['email'];
    $time = $_POST['addedon'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUCCESS</title>
</head>
<body>
    <h1>STATUS: <span id="status"><?php echo $status;?></span></h1>
    <h1 id="txnid"><?php echo $txnid;?></h1>
    <h1 id="username"><?php echo $username;?></h1>
    <h1 id="email"><?php echo $email;?></h1>
    <h1 id="time"><?php echo $time;?></h1>
</body>
<script type='module'>
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-analytics.js";
    import { getFirestore, doc, query, getDoc, getDocs, setDoc, collection, addDoc, updateDoc, deleteDoc, deleteField } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-firestore.js"
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "AIzaSyCy8Z8o59w85Ej4wh-oBnn_o8cAahhz0UU",
        authDomain: "gamex-bd2bd.firebaseapp.com",
        projectId: "gamex-bd2bd",
        storageBucket: "gamex-bd2bd.appspot.com",
        messagingSenderId: "716291758834",
        appId: "1:716291758834:web:dd67a71a0909430ef64e6b",
        measurementId: "G-3V6QB1VEZN"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
    const db = getFirestore();


    let status = document.getElementById('status').innerText;
    let txnid = document.getElementById('txnid').innerText;
    let username = document.getElementById('username').innerText;
    let email = document.getElementById('email').innerText;
    let time = document.getElementById('time').innerText;

    if (status === 'success'){
        // Getting values of IDs
        let GET = localStorage.getItem('GET');
        let parsedGet = JSON.parse(GET);
        let Eid = parsedGet.eid;
        let tid = parsedGet.tid;
        console.log(Eid);
        console.log(tid);
       
        // Getting old DATA from Database
        let docRef = doc(db, 'entries', tid);
        let docSnap = await getDoc(docRef);
        let p = JSON.stringify((docSnap.data()));
        let s = JSON.parse(p);
        console.log(s);
        let entry_ID = s[Eid].entryID;
        let g_uid = s[Eid].gUID;
        let g_username = s[Eid].gUsername;
        let username = s[Eid].username;
        console.log(entry_ID);
        console.log(g_uid);
        console.log(g_username);
        console.log(username);
    
     
        // Updating New data in OLD database
        var ref = doc(db, 'entries', tid);
        const docReff = await updateDoc(ref, {
            [Eid]: {
                Entry_ID: Eid,
                gUID : g_uid,
                gUsername : g_username,
                paymentStatus : 'done',
                username : username
            }
        });
        let reff = doc(db, 'transactions', txnid);
        const docRefff = await setDoc(reff, {
            txnid: txnid,
            status: status,
            username: username,
            email: email,
            time: time,
            tournamentID: tid,
            entryID: Eid
        }).then(function(){
            setTimeout(() => {
                window.location.assign('index.html');
            }, 5000);
        });
    }else{
        console.log('Failed: try again!');
    }
</script>
</html>