var config = {
    apiKey: "AIzaSyAgtkRIAGjehnnlVJ0yOV7Rtb8EVtYDP8g",
    authDomain: "banket-b.firebaseapp.com",
    databaseURL: "banket-b.firebaseio.com",
    projectId: "banket-b",
    storageBucket: "banket-b.appspot.com",
};
var app = firebase.initializeApp(config);
var database = firebase.database();
firebase.database().ref("/").on('value', function (snapshot) {
    console.log(
        snapshot.val()
    );
})

class Messenger extends React.PureComponent {

    render() {
        return (
            {/*<Div>rrr</Div>*/}
        )
    };
}




