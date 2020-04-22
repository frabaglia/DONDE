select establecimiento, calle,altura,
       ( 3959 * acos( cos( radians(-34.58929) ) 
              * cos( radians( places.latitude ) ) 
              * cos( radians( places.longitude ) - radians(-58.5085426) ) 
              + sin( radians(-34.58929) ) 
              * sin( radians( places.latitude ) ) ) ) *1000 AS distance 
from places 
where aprobado = 1 
having distance < 5000 ORDER BY distance
LIMIT 30;