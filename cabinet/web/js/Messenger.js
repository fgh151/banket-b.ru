class Messenger extends React.PureComponent {

    state = {
        loaded: false,
        items: []
    };

    static isMy(model) {
        return model.author_class === 'app\\common\\models\\Organization';
    }

    componentDidMount() {
        var config = {
            apiKey: "AIzaSyAgtkRIAGjehnnlVJ0yOV7Rtb8EVtYDP8g",
            authDomain: "banket-b.firebaseapp.com",
            databaseURL: "banket-b.firebaseio.com",
            projectId: "banket-b",
            storageBucket: "banket-b.appspot.com",
        };
        var app = firebase.initializeApp(config);
        var database = firebase.database();
        firebase.database().ref(ref).on('value', (snapshot) => {
            this.updateList(snapshot.val())
        })
    }

    updateList(items) {
        console.log(items);
        this.setState({
            items: Object.values(items),
            loaded: true,
        }, () => this.scroll());
    }

    scroll() {
        if ($('#messages-area > div').last().offset() > 500) {

            var scroll = $('#messages-area');
            var height = scroll[0].scrollHeight;
            scroll.scrollTop(height);
        }
    }

    render() {
        if (this.state.loaded) {
            return this.state.items.map((message) => <Message isMy={Messenger.isMy(message)} message={message}/>)
        }
        return (

            <div className={'fa fa-circle-o-notch fa-spin loading'}></div>
        )
    }
}

class Message extends React.PureComponent {
    constructor(props) {
        super(props)
    }

    render() {
        return (
            <div className={'row'}>
                <div className={this.props.isMy ? 'organization-message message' : 'user-message message'}>
                    {this.props.message.message}
                </div>
            </div>
        )
    }
}

ReactDOM.render(
    <Messenger/>,
    document.getElementById('messages-area')
);