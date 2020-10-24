# location of template file
template_location = ""

# location to save newly created files
write_location = "output/"

# open template file
f = open(template_location+"subjectplace.php", "r")
oldtext = f.read()


# ==================================================================
# === Eat - PDX ===
# replace variables
newtext = oldtext.replace("@1@", "#333")
newtext = newtext.replace("@2@", "Eat in PDX")
newtext = newtext.replace("@3@", "A list of my favorite places to eat at in Portland, Oregon. I hope you enjoy these recommendations.")
newtext = newtext.replace("@4@", "Map,Food,Eat,Portland,Oregon,PDX,OR")
newtext = newtext.replace("@5@", "eatPDX.php")
newtext = newtext.replace("@6@", "Brandon Booth")
newtext = newtext.replace("@7@", "projects_eatPDX.png")
newtext = newtext.replace("@8@", "Where%20to%20eat%20in%20Portland,%20Oregon.")
newtext = newtext.replace("@9@", "eatPDX")
newtext = newtext.replace("@10@", "Spring 2020")

# write copy of file contents with variable(s) replaced
f = open(write_location+"eatPDX.php", "w")
f.write(newtext)
f.close()


# ==================================================================
# === Breweries - PDX ===
# replace variables
newtext = oldtext.replace("@1@", "#333")
newtext = newtext.replace("@2@", "Breweries in PDX")
newtext = newtext.replace("@3@", "A comprehensive list of Breweries in Portland, Oregon. I hope you enjoy these recommendations.")
newtext = newtext.replace("@4@", "Map,Food,Breweries,Eat,Portland,Oregon,PDX,OR")
newtext = newtext.replace("@5@", "breweriesPDX.php")
newtext = newtext.replace("@6@", "Brandon Booth")
newtext = newtext.replace("@7@", "projects_BreweriesPDX.png")
newtext = newtext.replace("@8@", "Breweries%20in%20Portland,%20Oregon.")
newtext = newtext.replace("@9@", "breweriesPDX")
newtext = newtext.replace("@10@", "Spring 2020")

# write copy of file contents with variable(s) replaced
f = open(write_location+"breweriesPDX.php", "w")
f.write(newtext)
f.close()


# ==================================================================
# === Eat - SF ===
# replace variables
newtext = oldtext.replace("@1@", "#333")
newtext = newtext.replace("@2@", "Eat in SF")
newtext = newtext.replace("@3@", "A list of my favorite places to eat at in Portland, Oregon. I hope you enjoy these recommendations.")
newtext = newtext.replace("@4@", "Map,Food,Eat,Portland,Oregon,PDX,OR")
newtext = newtext.replace("@5@", "eatSF.php")
newtext = newtext.replace("@6@", "Brandon Booth")
newtext = newtext.replace("@7@", "projects_eatSF.png")
newtext = newtext.replace("@8@", "Where%20to%20eat%20in%20Portland,%20Oregon.")
newtext = newtext.replace("@9@", "eatSF")
newtext = newtext.replace("@10@", "Spring 2020")

# write copy of file contents with variable(s) replaced
f = open(write_location+"eatSF.php", "w")
f.write(newtext)
f.close()


# ==================================================================
# === Breweries - SF ===
# replace variables
newtext = oldtext.replace("@1@", "#333")
newtext = newtext.replace("@2@", "Breweries in SF")
newtext = newtext.replace("@3@", "A comprehensive list of Breweries in San Francisco, Oregon. I hope you enjoy these recommendations.")
newtext = newtext.replace("@4@", "Map,Food,Breweries,Eat,San Francisco,California,SF,CA")
newtext = newtext.replace("@5@", "breweriesSF.php")
newtext = newtext.replace("@6@", "Brandon Booth")
newtext = newtext.replace("@7@", "projects_BreweriesSF.png")
newtext = newtext.replace("@8@", "Breweries%20in%20San%20Francisco,%20California.")
newtext = newtext.replace("@9@", "breweriesSF")
newtext = newtext.replace("@10@", "Spring 2020")

# write copy of file contents with variable(s) replaced
f = open(write_location+"breweriesSF.php", "w")
f.write(newtext)
f.close()


print("Done!")