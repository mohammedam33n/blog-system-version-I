<template>
    <a class="cartbox_active" href="#">
        <span class="product_qun" v-if="unreadCount > 0">{{ unreadCount }}</span>
    </a>


    <!-- Start Shopping Cart -->
    <div class="block-minicart minicart__active">
        <div class="minicart-content-wrapper" v-if="unreadCount > 0">
            <div class="single__items">
                <div class="miniproduct">


                    <div class="item01 d-flex mt--20" v-for="item in unread" :key="item.id">


                        <div class="thumb">
                            <a :href="`edit-comment/${item.data.id}`" @click="readNotifications(item)"><img
                                    src="/frontend/images/icons/comment.png" :alt="`${item.data.post_title}`"></a>
                        </div>


                        <div class="content">
                            <a :href="`edit-comment/${item.data.id}`" @click="readNotifications(item)">
                                You have new comment on your post: {{ item.data.post_title }}</a>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- End Shopping Cart -->
</template>

<script>

export default {

    data() {
        return {
            read: {},
            unread: {},
            unreadCount: 0
        }
    }, created() {



        let userId = $('meta[name="userId"]').attr('content');
        if (userId != '') {
            this.getNotifications();
            console.log('getNotifications');
            Echo.private('App.User.' + userId)
                .notification((notification) => {
                    this.unread.unshift(notification);
                    this.unreadCount++;
                });
        }





    },
    methods: {

        getNotifications() {
            axios.get('user/notifications/get').then(res => {
                this.read = res.data.read;
                console.log(this.read);
                this.unread = res.data.unread;
                this.unreadCount = res.data.unread.length;
            }).catch(error => Exception.handle(error))
        },

        readNotifications(notification) {
            axios.post('user/notifications/read', { id: notification.id }).then(res => {
                this.unread.splice(notification, 1);
                this.read.push(notification);
                this.unreadCount--;
            })
        }

    },
}
</script>
