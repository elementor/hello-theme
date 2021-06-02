<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Comment Reply Script.
if ( comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
?>
<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="title-comments">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				printf( esc_html_x( 'One Response', 'comments title', 'hello-elementor' ) );
			} else {
				printf(
					esc_html( /* translators: 1: number of comments */
						_nx(
							'%1$s Response',
							'%1$s Responses',
							$comments_number,
							'comments title',
							'hello-elementor'
						)
					),
					esc_html( number_format_i18n( $comments_number ) )
				);
			}
			?>
		</h3>

		<?php the_comments_navigation(); ?>

	<ol class="comment-list">
		<?php
		wp_list_comments(
			[
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 42,
			]
		);
		?>
	</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

<?php endif; // Check for have_comments(). ?>

<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'hello-elementor' ); ?></p>
<?php endif; ?>

<?php
comment_form(
	[
		'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h2>',
	]
);
?>

</section><!-- .comments-area -->
