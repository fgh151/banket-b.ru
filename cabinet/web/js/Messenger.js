var config = {
    apiKey: "AIzaSyAgtkRIAGjehnnlVJ0yOV7Rtb8EVtYDP8g",
    authDomain: "banket-b.firebaseapp.com",
    databaseURL: "banket-b.firebaseio.com",
    projectId: "banket-b",
    storageBucket: "banket-b.appspot.com",
};
var app = firebase.initializeApp(config);
var database = firebase.database();

const proposal = JSON.parse(phpProposal);

class Messenger extends React.PureComponent {

    state = {
        loaded: false,
        items: []
    };

    static isMy(model) {
        return model.author_class === 'app\\common\\models\\Organization';
    }

    componentDidMount() {

        database.ref(ref).on('value', (snapshot) => {
            this.updateList(snapshot.val())
        })
    }

    static scroll() {
        var scroll = $('#messages');
        var height = scroll[0].scrollHeight;
        scroll.scrollTop(height);
    }

    updateList(items) {
        let state = {loaded: true};
        if (items !== null) {
            state.items = Object.values(items);
        }
        this.setState(state, () => Messenger.scroll());
    }

    render() {
        let form = proposalActive ? <Form/> : '';
        let messages = this.state.items.map((message) => <Message isMy={Messenger.isMy(message)} message={message}/>);
        if (this.state.loaded) {
            return (
                <div>
                    <div className={'messages-area'} id={'messages'}>
                        {messages}
                    </div>
                    {form}
                </div>
            )
        }
        return (
            <img src={'/img/preloader.gif'} className={'preloader'} alt={'preloader'}/>
        )
    }
}

class Message extends React.PureComponent {

    time = null;

    constructor(props) {
        super(props);

        var date = new Date(this.props.message.created_at * 1000);


        this.time = date.getHours() + ':' + date.getMinutes();
    }

    render() {
        return (
            <div className={'row'}>
                <div className={this.props.isMy ? 'organization-message message' : 'user-message message'}>
                    <div>
                        {this.props.message.message}
                    </div>
                    <div className={'message-time'}>
                        {this.time}
                    </div>
                </div>
            </div>
        )
    }
}

class Form extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            author_class: "app\\common\\models\\Organization",
            organization_id: organizationId,
            proposal_id: proposal.id,
            message: "",
            btnDisabled: true,
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit} className={'message-form'}>
                <div className={'row'}>
                    <div className={'col-xs-10 col-md-11'}>
                        <input type="text" value={this.state.message} onChange={this.handleChange}
                               placeholder={'Сообщение'}
                               className={'message-input'}/>
                    </div>
                    <div className={'col-xs-2 col-md-1'}>
                        <button className={'send-button'}/>
                    </div>
                </div>
            </form>

        )
    }

    handleSubmit(event) {
        event.preventDefault();

        const created_at = moment().format('X').toString();
        const path = ref + '/' + created_at;

        database.ref(path).set({
            author_class: this.state.author_class,
            organization_id: organizationId,
            proposal_id: this.state.proposal_id,
            created_at: created_at,
            message: this.state.message,
        });
        this.setState({
            message: "",
            btnDisabled: true,
        });
    }

    handleChange() {
        this.setState({message: event.target.value});
    }
}

ReactDOM.render(
    <Messenger/>,
    document.getElementById('dialog')
);