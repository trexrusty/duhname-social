<script>
    let { reports } = $props()
    console.log(reports)
    import axios from 'axios'

    function hide_post(e) {
        axios.post('/admin/delete/post/' + e)
    }

    function ban_user(e) {
        axios.post('/admin/ban/user/' + e)
    }

    const clear_post_report = (e) => {
        axios.post('/admin/clear/post/report/' + e)
    }
</script>

<div>
    <h1>Reports</h1>
</div>
{#if reports.length > 0}
<div class="flex flex-col gap-4 justify-center items-center">
    {#each reports as report}
        {#if report}
            <div class="bg-white p-4 rounded-md shadow-md text-black mb-4 ">
                <h2>Post: {report.content}</h2>
                <a href={`/admin/user/${report.user_id}`}>{report.user_id}</a>
                <button class="bg-green-500 text-white p-2 rounded-md" onclick={hide_post(report.id)}>Hide</button>
                <button class="bg-red-500 text-white p-2 rounded-md" onclick={ban_user(report.user_id)}>ban user</button>
                <button class="bg-red-500 text-white p-2 rounded-md" onclick={clear_post_report(report.id)}>clear post report</button>
            </div>
        {:else if report.comment}
            <div>
                <h2>{report.comment.content}</h2>
            </div>
        {/if}
    {/each}
</div>
{:else}
    <div>
        <p>No reports found</p>
    </div>
{/if}
