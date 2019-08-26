import Modules.picture as picture

if __name__ == "__main__":
    
    newPicture = picture.Picture()
    nonemptyPicture = picture.Picture("C:/hello.world.png");

    print(newPicture)
    print(nonemptyPicture)

    newPicture.setName("name1.jpg.gif")
    print(newPicture)