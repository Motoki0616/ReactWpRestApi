class PostList extends React.Component {
    constructor(props) {
    super(props);
    this.state = {posts: []};
    }

    render(){
        const posts = this.state.posts;
        return (
            <div className="container">
            <div className="post-list">
            {posts.map(post=><Post post={post} key={post.id}/>)}
            </div>
            </div>
        )
    }

    componentWillMount() {
        const requestUrl = 'http://localhost/ReactWordpress/wp-json/wp/v2/posts?per_page=20';
        const state = this;
        axios.get(requestUrl).then(function (res) {
          state.setState({posts:res.data});
        }, function (res) {
          throw new Error('Unable to fetch data.');
        });

    }
}

const Post = (props) => {
    const post = props.post;
    return (
        <article className="post">
            <div className="post-content">
                <img src={post.fi_300x180}/>
                <h2>{post.title.rendered}</h2>
                <Cat post={post}/>
            </div>
        </article>
    )
}

const Cat = (props) => {
    const cats = props.post.cats;
    return (
        <div>
        {cats.map(cat=><small>{cat.name}</small>)}
        </div>
    )
}

ReactDOM.render(
<PostList />,
document.getElementById('app')
);
