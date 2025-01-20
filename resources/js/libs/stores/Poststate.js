import { writable } from 'svelte/store';

const createPostState = () => {
    const { subscribe, set, update } = writable({
        posts: [],
        lastPostId: null,
    });

    return {
        subscribe,
        set,
        update,
        initialize: (initialPosts, initialLastPostId) => {
            update(state => {
                // Only initialize if store is empty or has different initial posts
                if (state.posts.length === 0 || state.posts[0]?.id !== initialPosts[0]?.id) {
                    return {
                        posts: initialPosts,
                        lastPostId: initialLastPostId
                    };
                }
                return state;
            });
        },
        addPosts: (newPosts, newLastPostId) => {
            update(state => ({
                posts: [...state.posts, ...newPosts],
                lastPostId: newLastPostId
            }));
        },
        clear: () => {
            set({
                posts: [],
                lastPostId: null
            });
        }
    };
};

export const postState = createPostState();
