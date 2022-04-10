import Login from "../views/Login";
import Home from "../views/Home";
import Logout from "../views/Logout";
import RSS from "../views/RSS";
import Campaigns from "../views/Campaigns/Campaigns";
import Campaign from "../views/Campaigns/Campaign";

export default [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout
    },
    {
        path: '/rss',
        name: 'rss',
        component: RSS
    },
    {
        path: '/campaigns',
        name: 'campaigns',
        component: Campaigns
    },
    {
        path: '/campaign/:id',
        name: 'campaign',
        component: Campaign
    },
]
