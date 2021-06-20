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


class Client {

    constructor(authToken, baseUrl = '', {headers = {}} = {}) {
        this.headers = {
            'Accept': '*/*',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`,
            'Access-Control-Allow-Origin': 'http://user.banket-b.ois',
        };
        Object.assign(this.headers, headers);
        this.baseUrl = apihost; // baseUrl;
    }

    static sendCode(params) {
        const api = new Client();
        api.POST('/v2/auth/sendcode', params)
            .then(response => {
                if (response.hasOwnProperty('code')) {
                    let state = new GlobalState();
                    state.AuthCode = response.code;
                }
            })
    }

    static sendRegisterCode(params) {
        const api = new Client();
        api.POST('/v2/auth/sendregistercode', params)
            .then(response => {
                console.log(response)
                if (response.hasOwnProperty('code')) {
                    let state = new GlobalState();
                    state.AuthCode = response.code;
                }
            }).catch(e => console.log(e))
    }

    login(phone, code) {
        // Returns a Promise with the response.
        return this.POST('/v2/auth/index', {phone: phone, code: code});
    }

    getCurrentUser() {
        // If the request is successful, you can return the expected object
        // instead of the whole response.
        return this.GET('/auth')
            .then(response => response.user);
    }

    _fullRoute(url) {
        return `${this.baseUrl}${url}`;
    }

    _fetch(route, method, body, isQuery = false, debugInfo = '') {

        if (!route) throw new Error('Route is undefined');
        let fullRoute = this._fullRoute(route);


        if (isQuery && body) {
            let qs = require('qs');
            const query = qs.stringify(body);
            fullRoute = `${fullRoute}?${query}`;
            body = undefined;
        }
        let opts = {
            // mode: 'no-cors',
            method: method,
            headers: this.headers
        };
        if (body) {
            Object.assign(opts, {body: JSON.stringify(body)});
        }

        // console.log(fullRoute, body);

        return this.onlineFetch(fullRoute, opts, debugInfo);

    }

    onlineFetch(fullRoute, opts, debugInfo = '') {
        const fetchPromise = () => fetch(fullRoute, opts);


        // console.log(connectionInfo.type);

        // if (connectionInfo.type !== 'none') {
        return fetchPromise()
            .then(response => {
                // console.log(response);
                // response.json().then(data => console.log(data, debugInfo, fullRoute));
                return response.json()
            });
    }


    GET(route, query, debugInfo = '') {
        return this._fetch(route, 'GET', query, true, debugInfo);
    }

    POST(route, body) {
        return this._fetch(route, 'POST', body);
    }

    PUT(route, body) {
        return this._fetch(route, 'PUT', body);
    }

    DELETE(route, query) {
        return this._fetch(route, 'DELETE', query, true);
    }
};

class Messenger extends React.PureComponent {

    state = {
        loaded: false,
        items: []
    };

    static isMy(model) {
        return model.author_class === 'app\\common\\models\\MobileUser';
    }

    static scroll() {
        var scroll = $('#messages');
        var height = scroll[0].scrollHeight;
        scroll.scrollTop(height);
    }

    componentDidMount() {

        database.ref(ref).on('value', (snapshot) => {
            this.updateList(snapshot.val())
        })
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


        this.time = date.getDay() + ' ' + date.getMonth() + ' ' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
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
            // author_class: "app\\common\\models\\Organization",
            // organization_id: organizationId,
            // proposal_id: proposal.id,
            // message: "",
            // btnDisabled: true,


            author_class: "app\\common\\models\\MobileUser",
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
        $.post(pushUrl, {organization: organizationId, message: this.state.message});
    }

    handleChange(event) {
        this.setState({message: event.target.value});
    }
}

class Dialogs extends React.Component {

    state = {
        items: [],
        listTitle: '',
        loaded: false,
    };

    /**
     * fetch data from API
     */
    componentDidMount() {
        const api = new Client(token);
        api.GET('/proposal/dialogs/' + proposal.id)
            .then(
                (responseData) => {
                    this.updateList(responseData);
                }
            )

    }

    updateList(items) {
        // noinspection JSAccessibilityCheck
        this.setState({
            items: items,
            loaded: true,
            refreshing: false
        });
    }

    render() {
        if (!this.state.loaded) {
            return (
                <img src={'/img/preloader.gif'} className={'preloader'} alt={'preloader'}/>
            )
        }

        if (this.state.items.length < 1) {
            return (
                <div>Пока никто не отозвался</div>
            )
        }

        return (
            <ul className={'list-group'}>
                {this.state.items.map(function (org) {
                    return <DialogItem org={org}/>
                })}
            </ul>
        );
    }
}

class DialogItem extends React.PureComponent {

    constructor(props) {
        super(props);
        this.onClick = this.onClick.bind(this);
    }

    onClick() {
        window.ref = 'proposal_2/u_' + proposal.owner_id + '/p_' + proposal.id + '/o_' + this.props.org.id;
        window.organizationId = this.props.org.id;
        destroyChat();
        initChat();
    }

    render() {
        return (
            <a href="#" className={'list-group-item js-open-chat'} onClick={this.onClick}>{this.props.org.name}</a>
        )
    }

}

ReactDOM.render(
    <Dialogs/>,
    document.getElementById('dialogs')
);

function destroyChat() {
    ReactDOM.unmountComponentAtNode(document.getElementById('dialog'));
}

function initChat() {
    ReactDOM.render(
        <Messenger/>,
        document.getElementById('dialog')
    );
}
