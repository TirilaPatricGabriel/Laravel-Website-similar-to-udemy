import { createRouter } from 'vue-router';
import { createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Register from '../components/auth/Register.vue';
import Login from '../components/auth/Login.vue';
import AddCourse from '../components/courses/AddCourse.vue';
import CoursesCreatedByUser from '../components/courses/CoursesCreatedByUser.vue';
import AuthorCoursePage from '../components/courses/AuthorCoursePage.vue';
import Episode from '../components/episodes/Episode.vue';
import BuyCourses from '../components/courses/BuyCourses.vue';
import Cart from '../components/cart/Cart.vue';
import CoursesBought from '../components/courses/CoursesBought.vue';
import Course from '../components/courses/Course.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/add-course',
        name: 'AddCourse',
        component: AddCourse
    },
    {
        path: '/courses-created-by-you',
        name: 'CoursesCreatedByUser',
        component: CoursesCreatedByUser
    },
    {
        path: '/courses-created-by-you/courses/:id',
        name: 'AuthorCoursePage',
        component: AuthorCoursePage
    },
    {
        path: '/episodes/:id',
        name: 'Episode',
        component: Episode
    },
    {
        path: '/buy-courses',
        name: 'BuyCourses',
        component: BuyCourses
    },
    {
        path: '/cart',
        name: 'Cart',
        component: Cart
    },
    {
        path: '/bought-courses',
        name: 'CoursesBought',
        component: CoursesBought
    },
    {
        path: '/course/:id',
        name: 'Course',
        component: Course
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router