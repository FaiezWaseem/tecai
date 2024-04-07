<!DOCTYPE html>
<html>

<head>
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        .endpoint {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
        }

        .endpoint h3 {
            font-size: 18px;
            margin-top: 0;
        }

        .endpoint p {
            margin-bottom: 5px;
        }

        .endpoint ul {
            margin: 0;
            padding-left: 20px;
        }

        .endpoint ul li {
            list-style-type: square;
            margin-bottom: 5px;
        }
        .post {
          background: red;
          padding: 3px 5px;
          color: white;
        }
        .get {
          background: green;
          padding: 3px 5px;
          color: white;
        }
        code {
          background-color: aliceblue;
          padding: 5px;
        }
    </style>
</head>

<body>
    <h1>API Documentation</h1>

    <div class="endpoint">
        <h3>Ecoaching Student Register</h3>
        <p>HTTP Method: <span class="post">POST</span> </p>
        <code>URL: /api/ecoaching/register</code>
        <p>Parameters:</p>
        <ul>
          <li>name - ex : 'student'</li>
          <li>email -  ex : 'student@gmail.com'</li>
          <li>password - ex : '1xxxxx'</li>
          <li>plan_id - ex : '1'</li>
          <li>payment_screenshot - ex : 'xyz@.com/screenshot.png'</li>
        </ul>
        <p>Example Response:</p>
        <pre>
          {
            "success": "You have successfully registered.",
            "status": true
          }
    </pre>
    </div>
    <div class="endpoint">
        <h3>Ecoaching Student Login</h3>
        <p>HTTP Method: <span class="post">POST</span> </p>
        <code>URL: /api/ecoaching/login</code>
        <p>Parameters:</p>
        <ul>
            <li>email -  ex : 'student@gmail.com'</li>
            <li>password - ex : '1xxxxx'</li>
        </ul>
        <p>Example Response:</p>
        <pre>
          {
            "success": "You have successfully logged in.",
            "user": {
              "id": 1,
              "name": "Student",
              "email": "student@gmail.com",
              "password": "$2y$12$/62GlSiI5wpnoACVxW/xheuLN/Otl5Np2qWCOieke.ZJFmZPNLL2S",
              "updated_at": "2024-04-07T11:17:48.000000Z",
              "created_at": "2024-04-07T11:17:48.000000Z"
            },
            "token": "eyJ0eXAiOiJKV1QiLCJhiOiJIUzI1NiJ9.eyJpwiOiJmYXp1ZmFpZXoxMUBC5jb20ifQ.0B3IOorfu9eYk_OECNTgJvwR39Ld_CE7k"
          }
    </pre>
    </div>
    </div>
    {{-- Student Plans --}}
    <div class="endpoint">
        <h3>Ecoaching Student Plans</h3>
        <p>HTTP Method: <span class="get">GET</span> </p>
        <code>URL: /api/ecoaching/plans</code>
        <p>Parameters:</p>
        <ul>
            
        </ul>
        <p>Example Response:</p>
        <pre>
          {
            "plans": [
              {
                "id": 1,
                "plan_name": "PLAN A",
                "plan_details": "Sindhboard , 9th , 10th ,11th ,12th Class Notes , online Sessions etc",
                "plan_price": "4000",
                "updated_at": "2024-04-06T12:11:20.000000Z",
                "created_at": "2024-04-06T12:11:20.000000Z"
              }
            ],
            "status": false
          }
    </pre>
    </div>
    {{-- Guest Courses --}}
    <div class="endpoint">
        <h3>Ecoaching Guest Courses</h3>
        <p>HTTP Method: <span class="get">GET</span> </p>
        <code>URL: /api/ecoaching/guest/courses</code>
        <p>Parameters:</p>
        <ul>
        </ul>
        <p>Example Response:</p>
        <pre>
          {
            "courses": [
              {
                "id": 1,
                "course_name": "Biology2",
                "updated_at": "2024-02-23T09:40:13.000000Z",
                "created_at": "2024-01-30T07:02:39.000000Z",
                "thumbnail": "65d866dde4fa1.png"
              }
            ],
            "status": true
          }
    </pre>
    </div>
   {{-- Student Courses --}}
    <div class="endpoint">
      <h3>Ecoaching Student Courses</h3>
      <p>HTTP Method: <span class="post">POST</span> </p>
      <code>URL: /api/ecoaching/courses</code>
      <p>Headers</p>
      <ul>
        <li>Authorization : "Bearer <i>student_token_here</i>"</li>
      </ul>
      <p>Parameters:</p>
      
      <p>Example Response:</p>
      <pre>
        {
          "courses": [
            {
              "id": 1,
              "course_name": "Biology2",
              "updated_at": "2024-02-23T09:40:13.000000Z",
              "created_at": "2024-01-30T07:02:39.000000Z",
              "thumbnail": "65d866dde4fa1.png"
            }
          ],
          "status": true
        }
  </pre>


</body>

</html>
