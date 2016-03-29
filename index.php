<?php
$start = microtime(true);

//generate first dataset
for($i=0;$i<10000;$i++){
	$dataset1[] = mt_rand(1,10000);
}
//remove duplicate values
$unique_dataset1 = array();
for($i=0;$i<10000;$i++){
	if(!in_array($dataset1[$i], $unique_dataset1))
		$unique_dataset1[$dataset1[$i]] = $dataset1[$i];
}

//generate second dataset
for($i=0;$i<10000;$i++){
	$dataset2[] = mt_rand(1,10000);
}
//remove duplicate values
$unique_dataset2 = array();
for($i=0;$i<10000;$i++){
	if(!in_array($dataset2[$i], $unique_dataset2))
		$unique_dataset2[] = $dataset2[$i];
}

//check for common values
$count = count($unique_dataset2);
for($i=0;$i<$count;$i++) {
	if(array_key_exists ($unique_dataset2[$i], $unique_dataset1))
		$common[] = $unique_dataset2[$i];
}

$data = mergesort($common); //sort array

echo "Total number of common values: " . count($data) . "<br>";
print_r($data);
echo "<br><br>";
echo "Execution time: " . $time_elapsed_secs = microtime(true) - $start;
?>

<?php
function mergesort($data) {
    // Only process if we're not down to one piece of data
    if(count($data)>1) {
        
        // Find out the middle of the current data set and split it there to obtain to halfs
        $data_middle = round(count($data)/2, 0, PHP_ROUND_HALF_DOWN);
        // and now for some recursive magic
        $data_part1 = mergesort(array_slice($data, 0, $data_middle));
        $data_part2 = mergesort(array_slice($data, $data_middle, count($data)));
        // Setup counters so we can remember which piece of data in each half we're looking at
        $counter1 = $counter2 = 0;
        // iterate over all pieces of the currently processed array, compare size & reassemble
        for ($i=0; $i<count($data); $i++) {
            // if we're done processing one half, take the rest from the 2nd half
            if($counter1 == count($data_part1)) {
                $data[$i] = $data_part2[$counter2];
                ++$counter2;
            // if we're done with the 2nd half as well or as long as pieces in the first half are still smaller than the 2nd half
            } elseif (($counter2 == count($data_part2)) or ($data_part1[$counter1] < $data_part2[$counter2])) { 
                $data[$i] = $data_part1[$counter1];
                ++$counter1;
            } else {
                $data[$i] = $data_part2[$counter2];
                ++$counter2;
            }
        }
    }
    return $data;
}
?>