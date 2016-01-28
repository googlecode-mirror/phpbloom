A working port of the bloom filter implementation documented here: http://www.coolsnap.net/kevin/?p=13 along with a port of the BitField class here: http://snippets.dzone.com/posts/show/4234 to save on space and because gmp\_bittest isn't going to be in a stable release of php before 5.3 which forces us to use gmp\_scan0 or gmp\_scan1 which has a worst case of O(n).

Current version: 1.0