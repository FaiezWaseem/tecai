<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            /* Eliminar predeterminados */
            margin: 0;
            padding: 0;
        }

        .title {
            /* Estilos de título h1 */
            text-align: center;
            padding: 20px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .pdfview {
            /* Centrado */
            margin: auto;
            display: block;
            /* Tamaño */
            width: 80vw;
            height: 100vh;
            /* Mejorar aspecto */
            border-radius: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
    <title>View PDF</title>
</head>
<body>
    <div id="pdfContainer"></div>

    <script>
        // Fetch the PDF dynamically
        fetch("{{ route('preview.file.download',['id'=> $id]) }}", {
            method: "GET",
            headers: {
                "Content-Type": "application/pdf"
            }
        })
        .then(response => response.blob())
        .then(blob => {
            // Create a URL for the blob
            const url = URL.createObjectURL(blob);

            // Create an object element to display the PDF
            const objectElement = document.createElement("object");
            objectElement.className = "pdfview";
            objectElement.type = "application/pdf";
            objectElement.data = url+'#toolbar=0';

            // Append the object element to the PDF container
            const pdfContainer = document.getElementById("pdfContainer");
            pdfContainer.appendChild(objectElement);
        })
        .catch(error => {
            console.error("Error fetching the PDF:", error);
        });
    </script>
</body>
</html>