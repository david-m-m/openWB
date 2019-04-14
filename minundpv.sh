#!/bin/bash
########################
#Min Ladung + PV Uberschussregelung lademodus 1
minundpvlademodus(){
	if (( ladestatus == 0 )); then
		runs/set-current.sh $minimalampv all
		if [[ $debug == "1" ]]; then
			echo "starte min + pv ladung mit $minimalampv"
		fi
	else
		if (( ladeleistung < 500 )); then
			llneu=$minimalampv
			#runs/set-current.sh $llneu all 
		else
			if (( uberschuss < pvregelungm )); then
				if (( llalt > minimalampv )); then
					if (( uberschuss < -1380 )); then
						if (( anzahlphasen < 4 )); then
							llneu=$((llalt - 6 ))
						else
							llneu=$((llalt - 2 ))
						fi
						if (( uberschuss < -2760 )); then
							if (( anzahlphasen < 4 )); then
								llneu=$((llalt - 12 ))
							else
								llneu=$((llalt - 4 ))
							fi
						fi
					else
						llneu=$((llalt - 1 ))
					fi
					#runs/set-current.sh $llneu all
				else
					llneu=$minimalampv
					#runs/set-current.sh $llneu all
				fi
			fi
			if (( uberschuss > schaltschwelle )); then
				if (( uberschuss > 1380 )); then
					if (( anzahlphasen < 4 )); then
						llneu=$((llalt + 5 ))
					else
						llneu=$((llalt + 2 ))
					fi
					if (( uberschuss > 2760 )); then
						if (( anzahlphasen < 4 )); then
							llneu=$((llalt + 11 ))
						else
							llneu=$((llalt + 3 ))
						fi
					fi

				else
					llneu=$((llalt + 1 ))
				fi
			fi
		fi
	fi
	if (( llneu < minimalampv )); then
		llneu=$minimalampv
	fi
	if (( llneu > maximalstromstaerke )); then
		llneu=$maximalstromstaerke
	fi
	runs/set-current.sh $llneu all
}

