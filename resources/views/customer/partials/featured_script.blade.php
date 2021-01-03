<script>
      function addFeaturedAjax(postId){
            return $.ajax({
                url: '/featured/add',
                data: {
                    post_id: postId,
                },
                type: 'POST',
            })
        }

        function checkHeart(heart){
            heart.html(`<i class="fas fa-heart font-12 text-danger"></i>`);
        }

        function uncheckHeart(heart){
            heart.html(`<i class="far fa-heart font-12 text-info"></i>`);
        }

        function removeFeaturedAjax(postId){
            return $.ajax({
                url: '/featured/remove',
                data: {
                    post_id: postId,
                },
                type: 'POST',
            })
        }

        $(document).on('click', '.like-heart.unchecked', function(){
            var postId = $(this).data('post-id');
            var element = $(this);
            addFeaturedAjax(postId)
            .done(function(data){
                element.removeClass('unchecked');
                element.addClass('checked');
                checkHeart(element)
            })
            .fail(function(error){
                if (error.status == 401) {
                    swalAlert('Bạn vui lòng đăng nhập để thực hiện lưu tin', 'error')
                }
            });
        })

        $(document).on('click', '.like-heart.checked', function(){
            var postId = $(this).data('post-id');
            var element = $(this);
            removeFeaturedAjax(postId)
            .done(function(data){
                element.removeClass('checked');
                element.addClass('unchecked');
                uncheckHeart(element);
            })
            .fail(function(error){
                if (error.status == 401) {
                    swalAlert('Bạn vui lòng đăng nhập để thực hiện bỏ lưu tin', 'error')
                }
            });
        })
</script>
