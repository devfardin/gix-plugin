jQuery(document).ready(function ($) {
    $('.clean-btn').on('click', function (e) {
        const user_id = $(this).data('user_id');
        const post_id = $(this).data('post_id');
        const ip_address = $(this).data('ip_address');
        const reaction_type = $(this).data('reaction_type');

        if (!user_id) {
            alert('Please log in before liking the post.');
        } else {
            $.ajax({
                type: 'POST',
                url: siteinfo.admin_url,
                data: {
                    action: 'gix_ajax_voti',
                    post_id,
                    user_id,
                    ip_address,
                    reaction_type,
                    nonce: siteinfo.nonce,
                },
                success: function (response) {
                    alert(response.data.message)
                    console.log(response.data.message);

                },
                error: function (err) {
                    console.log(err.data.message)
                }
            })
        }
    })

    // $('.disline-btn').on('click', function () {
    //     const user_id = $(this).data('user_id');
    //     const post_id = $(this).data('post_id');
    //     const ip_address = $(this).data('ip_address');

    //     if (!user_id) {
    //         alert('Please log in before dislike the post.');
    //     } else {
    //         $.ajax({
    //             type: 'POST',
    //             url: siteinfo.admin_url,
    //             data: {
    //                 action: 'gix_ajax_voti',
    //                 post_id,
    //                 user_id,
    //                 ip_address,
    //             },
    //             success: function (response) {
    //                 alert(response.data.message)
    //                 console.log(response.data.message);

    //             },
    //             error: function (err) {
    //                 console.log(err.data.message)
    //             }
    //         })
    //     }

    // })
})