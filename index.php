<?php
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
$sortKey = isset($_GET['sort']) ? $_GET['sort'] : '';

$data = [
    [
        "id" => 1,
        "judul" => "Inception",
        "genre" => "Sci-Fi",
        "popularitas" => 90,
        "rating" => 4.8,
        "tahun_rilis" => 2010,
        "pemeran_utama" => "Leonardo DiCaprio"
    ],
    [
        "id" => 2,
        "judul" => "The Godfather",
        "genre" => "Drama",
        "popularitas" => 95,
        "rating" => 4.9,
        "tahun_rilis" => 1972,
        "pemeran_utama" => "Marlon Brando"
    ],
    [
        "id" => 3,
        "judul" => "Interstellar",
        "genre" => "Sci-Fi",
        "popularitas" => 85,
        "rating" => 4.7,
        "tahun_rilis" => 2014,
        "pemeran_utama" => "Matthew McConaughey"
    ],
    [
        "id" => 4,
        "judul" => "Avengers: Endgame",
        "genre" => "Action",
        "popularitas" => 92,
        "rating" => 4.6,
        "tahun_rilis" => 2019,
        "pemeran_utama" => "Robert Downey Jr."
    ],
    [
        "id" => 5,
        "judul" => "Toy Story 3",
        "genre" => "Animation",
        "popularitas" => 80,
        "rating" => 4.5,
        "tahun_rilis" => 2010,
        "pemeran_utama" => "Tom Hanks"
    ]
];

function quickSort($data, $key) {
    if (count($data) < 2) {
        return $data;
    }

    $left = $right = [];
    $pivot = $data[0];

    for ($i = 1; $i < count($data); $i++) {
        if ($data[$i][$key] > $pivot[$key]) {
            $left[] = $data[$i];
        } else {
            $right[] = $data[$i];
        }
    }

    return array_merge(quickSort($left, $key), [$pivot], quickSort($right, $key));
}

function filterByGenre($data, $genre) {
    if (empty($genre)) {
        return $data;
    }
    return array_filter($data, function ($item) use ($genre) {
        return $item['genre'] === $genre;
    });
}

$filteredData = filterByGenre($data, $selectedGenre);
$validSortKeys = ['rating', 'popularitas', 'tahun_rilis'];
if (in_array($sortKey, $validSortKeys)) {
    $filteredData = quickSort($filteredData, $sortKey);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Film</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(to right, #141e30, #243b55);
            color: #333;
        }
        
        h2 {
            color: #f5f5f5;
            margin-top: 40px;
        }

        form {
            margin: 15px 0;
            display: inline-block;
        }

        label, select, input, button {
            font-size: 16px;
        }

        select, input, button {
            padding: 8px 12px;
            margin-left: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"], button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #ddd;
        }
    </style>
</head>
<body>
    <h2>Daftar Film</h2>

    <form method="GET" action="">
        <label for="genre" style="color: #f5f5f5;">Pilih Genre:</label>
        <select name="genre" id="genre">
            <option value="">Semua Genre</option>
            <option value="Action" <?php echo $selectedGenre == 'Action' ? 'selected' : ''; ?>>Action</option>
            <option value="Drama" <?php echo $selectedGenre == 'Drama' ? 'selected' : ''; ?>>Drama</option>
            <option value="Sci-Fi" <?php echo $selectedGenre == 'Sci-Fi' ? 'selected' : ''; ?>>Sci-Fi</option>
            <option value="Animation" <?php echo $selectedGenre == 'Animation' ? 'selected' : ''; ?>>Animation</option>
        </select>
        <input type="submit" value="Tampilkan">
    </form>

    <form method="get" action="">
        <label for="sort" style="color: #f5f5f5;">Urutkan Berdasarkan:</label>
        <select name="sort" id="sort">
            <option value="rating">Rating</option>
            <option value="popularitas">Popularitas</option>
            <option value="tahun_rilis">Tahun Rilis</option>
        </select>
        <button type="submit">Urutkan</button>
    </form>

    <table>
        <tr>
            <th>Judul</th>
            <th>Genre</th>
            <th>Popularitas</th>
            <th>Rating</th>
            <th>Tahun Rilis</th>
            <th>Pemeran Utama</th>
        </tr>

        <?php if (!empty($filteredData)): ?>
            <?php foreach ($filteredData as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['judul']); ?></td>
                    <td><?php echo htmlspecialchars($item['genre']); ?></td>
                    <td><?php echo htmlspecialchars($item['popularitas']); ?></td>
                    <td><?php echo htmlspecialchars($item['rating']); ?></td>
                    <td><?php echo htmlspecialchars($item['tahun_rilis']); ?></td>
                    <td><?php echo htmlspecialchars($item['pemeran_utama']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada data untuk ditampilkan.</td>
            </tr>
        <?php endif; ?>
    </table>

    <p>Menampilkan hasil untuk genre: <strong><?php echo !empty($selectedGenre) ? htmlspecialchars($selectedGenre) : 'Semua Genre'; ?></strong></p>
</body>
</html>
