async function gradeAssignment(marks_obtained, total_marks) {

    const domain = window.location.origin;
    function querystring(key) {
        var re = new RegExp('(?:\\?|&)' + key + '=(.*?)(?=&|$)', 'gi');
        var r = [], m;
        while ((m = re.exec(document.location.search)) != null) r[r.length] = m[1];
        return r;
    }
    if (querystring('teacher')[0]) {
        
        return;
    }
    if (!querystring('token')[0]) {
        alert('UnAuthorized Please Login First To Continue')
        window.location.href = domain;
        return;
    }
    if (!querystring('id')[0]) {
        alert('UnAuthorized Please Login First To Continue')
        window.location.href = domain;
        return;
    }

    let headersList = {
        "Accept": "*/*",
        "User-Agent": "Thunder Client (https://www.thunderclient.com)",
        "Authorization": `Bearer ${querystring('token')[0]}`,
        "Content-Type": "application/x-www-form-urlencoded"
    }

    let bodyContent = `points_obtained=${marks_obtained}&points_total=${total_marks}`;

    let response = await fetch(domain + "/api/grade/assignment/" + querystring('id')[0], {
        method: "POST",
        body: bodyContent,
        headers: headersList
    });

    let data = await response.json();
    return data;

}